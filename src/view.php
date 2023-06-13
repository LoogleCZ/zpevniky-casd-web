<?php
    $songbook = $_GET['songbook'];
    $song = $_GET['song'];

    preg_match_all('/([0-9]*) (.*)/m', $song, $matches, PREG_SET_ORDER, 0);

    $filename = basename($song);
    $name = $matches[0][2];
    $idx = $matches[0][1];

    $xml = simplexml_load_file(__DIR__ . '/download/' . $songbook . '/' . $song);
    if($xml === false) {
        header("Location: http://zpevniky-casd.cz/");
    }
    // http://localhost/zpevniky-casd-web/out/nahled/Zp%C3%ADvejme%20Hospodinu/fasd
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <title>Zpěvníky CASD - digitální podoba zpěvníků</title>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GCP8MSJBE2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-GCP8MSJBE2');
        </script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"
              rel="stylesheet" crossorigin="anonymous"/>
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"
              crossorigin="anonymous"/>
        <link href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.bootstrap5.min.css" rel="stylesheet"
              crossorigin="anonymous"/>
        <link href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.min.css" rel="stylesheet"
              crossorigin="anonymous"/>

        <link href="../../css/styles.css" rel="stylesheet"/>

        <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"
                crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"
                crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/searchPanes.bootstrap5.min.js"
                crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"
                crossorigin="anonymous"></script>
        <script src="../../js/datatable.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <h1>Digitální podoba zpěvníků používaných v CASD</h1>
            </div>
        </header>

        <main role="main" class="container">
            <a href="http://zpevniky-casd.cz/">Zpět na obsah</a>

            <h2><?= $songbook ?></h2>
            <h3><?= $idx ?> - <?= $name ?></h3>

            <div class="row">
                <?php
                $lyrics = trim($xml->xpath('//song/lyrics')[0]);
                $presentation = $xml->xpath('//song/presentation')[0];
                $presentation = explode(' ', $presentation);
                $finalForm = [];
                $currentSection = '';
                $lines = explode("\n", $lyrics);
                foreach ($lines as $line) {
                    if (preg_match_all('/^\[([a-zA-Z0-9]*)\]$/m', trim($line), $matches, PREG_SET_ORDER, 0)) {
                        $currentSection = $matches[0][1];
                        $finalForm[$currentSection] = '';
                        continue;
                    }

                    $finalForm[$currentSection] .= "\n" . trim($line);
                }
                ?>

                <aside class="col-1 text-end">
                    <pre><?php
                        foreach ($presentation as $item) {
                            $newlines = substr_count(trim($finalForm[$item]), "\n");
                            echo $item;
                            echo str_pad("", $newlines + 2, "\n");
                        }
                        ?></pre>
                </aside>
                <div class="col-11">
                    <pre><?php
                        foreach ($presentation as $item) {
                            echo trim($finalForm[$item]);
                            echo PHP_EOL . PHP_EOL;
                        }
                        ?></pre>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-lg-center">
                        <span class="text-muted">Martin Fabík <a href="mailto:mar.fabik@gmail.com">&lt;mar.fabik@gmail.com&gt;</a></span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
