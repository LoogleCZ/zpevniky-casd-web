<?php

include "src/DataObject.php";
$templateName = $argv[1];
$block = createBlockObject();

include "src/templates/$templateName";

function createBlockObject()
{
    $block = new DataObject();
    $block->setData('build_date', date('Y-m-d H:i:s'));
    $webCommit = `git rev-parse HEAD`;
    $block->setData('web_commit', $webCommit);
    $block->setData('web_commit_short', substr($webCommit, 0, 8));
    $dbCommit = `cd db && git rev-parse HEAD`;
    $block->setData('db_commit', $dbCommit);
    $block->setData('db_commit_short', substr($dbCommit, 0, 8));

    $songbooks = loadSongBooks();
    $block->setData('songbook-count', count($songbooks));
    $block->setData('songbooks', $songbooks);

    $block->setData('songs', fillSongs());

    return $block;
}

function loadSongBooks(): array
{
    $songbooks = glob('db/*', GLOB_ONLYDIR);
    $result = [];
    foreach ($songbooks as $songbook) {
        $songbook = basename($songbook);
        if($songbook[0] == '_') {
            continue;
        }
        $dto = new DataObject();
        $dto->setData('name', $songbook);
        $dto->setData('download-url', 'download/' . $songbook . '.zip');
        $dto->setData(
            'song-count',
            count(
                array_filter(
                    glob('db/' . $songbook . '/*'),
                    function ($name) {
                        return $name != '_metadata';
                    }
                )
            )
        );
        $result[] = $dto;
    }
    return $result;
}

function fillSongs(): array
{
    $songbooks = glob('db/*', GLOB_ONLYDIR);

    $out = [];
    foreach ($songbooks as $songbook) {
        $songbook = basename($songbook);
        if($songbook[0] == '_') {
            continue;
        }

        $songs = array_filter(
            glob('db/' . $songbook . '/*'),
            function ($name) {
                return $name != '_metadata';
            }
        );
        $songsOut = [];
        foreach ($songs as $song) {
            // TODO: read from OpenSong definition
            $song = basename($song);
            preg_match_all('/([0-9]*) (.*)/m', $song, $matches, PREG_SET_ORDER, 0);

            $songsOut[] =
                [
                    'filename' => basename($song),
                    'name' => $matches[0][2],
                    'idx' => $matches[0][1],
                ];
        }

        $out[$songbook] = $songsOut;
    }
    return $out;
}
