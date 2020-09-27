<?php include './components/header.php';

$voti = $argo->votiGiornalieri();
$schede = $argo->schede();

?>
<main>

    <div class="container">

        <h3 class="header">Valutazioni</h3>

        <hr>

        <div class="row">

            <div class="col s12" style="margin-bottom: 1rem;">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="voti.php">RIEPILOGO</a></li>
                    <li class="tab col s4"><a href="valutazioni.php">VALUTAZIONI</a></li>
                    <li class="tab col s4"><a href="scrutinio.php">SCRUTINIO</a></li>
                </ul>
            </div>

            <?php

            function coloreVoto($voto) {
                if ($voto <= 1) {
                    return 'red darken-4';
                } else if (($voto >= 1) && ($voto < 5)) {
                    return 'red';
                } else if (($voto >= 5) && ($voto < 6)) {
                    return 'orange darken-4';
                } else if (($voto >= 6) && ($voto < 7)) {
                    return 'lime';
                } else if (($voto >= 7) && ($voto < 8)) {
                    return 'lime darken-2';
                } else if (($voto >= 8) && ($voto < 9)) {
                    return 'light-green';
                } else if (($voto >= 9) && ($voto < 10)) {
                    return 'green';
                } else if ($voto >= 10) {
                    return 'green darken-2';
                }
            }

            function coloreGrafico($voto) {
                if ($voto <= 1) {
                    return '183, 28, 28';
                } else if (($voto >= 1) && ($voto < 5)) {
                    return '244, 67, 54';
                } else if (($voto >= 5) && ($voto < 6)) {
                    return '230, 81, 0';
                } else if (($voto >= 6) && ($voto < 7)) {
                    return '205, 220, 57';
                } else if (($voto >= 7) && ($voto < 8)) {
                    return '175, 180, 43';
                } else if (($voto >= 8) && ($voto < 9)) {
                    return '139, 195, 74';
                } else if (($voto >= 9) && ($voto < 10)) {
                    return '76, 175, 80';
                } else if ($voto >= 10) {
                    return '56, 142, 60';
                }
            }

            ?>

            <?php
            $materie = [];

            $votiTotSomma = 0;
            $votiTriSomma = 0;
            $votiPenSomma = 0;

            $votiTotCount = count($voti);
            $votiTriCount = 0;
            $votiPenCount = 0;

            $annoInizio = $schede[0]['annoScolastico']['datInizio'];
            $annoFine = $schede[0]['annoScolastico']['datFine'];

            for ($x = 0; $x < count($voti); $x++) {

                $materia = $voti[$x]['desMateria'];
                $voto = $voti[$x]['decValore'];
                $data = strtotime($voti[$x]['datGiorno']);

                // Array materie
                if (!in_array($materia, $materie)) {
                    array_push($materie, $materia);
                }

                if ($voto != 0) {

                    // Media totale
                    $votiTotSomma += $voto;

                    // Media trimetre
                    $dataTri = strtotime(explode('-', $annoInizio)[0] . '-12-31');
                    $dataPen = strtotime(explode('-', $annoFine)[0] . '-01-01');

                    if ($data <= $dataTri) {
                        $votiTriSomma += $voto;
                        $votiTriCount++;
                    } else if ($data >= $dataPen) {
                        $votiPenSomma += $voto;
                        $votiPenCount++;
                    }
                }
            }

            $mediaTot = round($votiTotSomma / $votiTotCount, 2);
            $mediaTri = round($votiTriSomma / $votiTriCount, 2);
            $mediaPen = round($votiPenSomma / $votiPenCount, 2);

            ?>

            <!--===================================
                RIEPILOGO VOTI
                ===================================-->
            <div id="riepilogo" class="col s12">

                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card-panel hoverable">
                            <b>Andamento Scolastico</b>
                            <canvas id="canvasAndamentoScolastico"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Complessiva</b>
                            <canvas id="canvasMediaComplessiva"></canvas>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Trimestre</b>
                            <canvas id="canvasMediaTrimestre"></canvas>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card-panel hoverable">
                            <b>Media Pentamestre</b>
                            <canvas id="canvasMediaPentamestre"></canvas>
                        </div>
                    </div>
                </div>

                <hr>

                <?php

                for ($i = 0; $i < count($materie); $i++) {

                    ${"sommaVoti1" . $i} = 0;
                    ${"numVoti1" . $i} = 0;
                    ${"listaVoti1" . $i} = [];

                    ${"sommaVoti2" . $i} = 0;
                    ${"numVoti2" . $i} = 0;
                    ${"listaVoti2" . $i} = [];

                    for ($j = 0; $j < count($voti); $j++) {

                        if ($voti[$j]['desMateria'] == $materie[$i]) {

                            if ($voti[$j]['decValore'] != 0) {
                                if (strtotime($voti[$j]['datGiorno']) <= strtotime('2019-12-31')) {
                                    ${"sommaVoti1" . $i} += $voti[$j]['decValore'];
                                    ${"numVoti1" . $i}++;
                                    array_push(${"listaVoti1" . $i}, $voti[$j]);
                                } else if (strtotime($voti[$j]['datGiorno']) >= strtotime('2020-01-01')) {
                                    ${"sommaVoti2" . $i} += $voti[$j]['decValore'];
                                    ${"numVoti2" . $i}++;
                                    array_push(${"listaVoti2" . $i}, $voti[$j]);
                                }
                            }

                        }
                    }
                }

                ?>

                <div class="row">
                    <div class="col s12">
                        <ul class="collapsible">
                            <?php

                            for ($i = 0; $i < count($materie); $i++) {

                                $sommaVoti = ${"sommaVoti1" . $i} + ${"sommaVoti2" . $i};
                                $numVoti = ${"numVoti1" . $i} + ${"numVoti2" . $i};
                                $media = round($sommaVoti / $numVoti, 2);

                            ?>
                                <li>
                                    <div class="collapsible-header" tabindex="0" style="background: linear-gradient(90deg, rgba(0,0,0,0) 50%, rgba(<?= coloreGrafico($media) ?> ,1) 100%);">
                                        <b><?= $materie[$i] ?></b>
                                        <span class="badge <?php if ($media < 6) {
                                                                echo 'text-white';
                                                            } ?>">MEDIA: <b><?= $media ?></b></span>
                                    </div>
                                    <div class="collapsible-body">
                                        <div class="row">

                                            <!-- SECONDO PERIODO -->
                                            <div class="col s6">
                                                <!-- media -->
                                                <?php $media2 = ${"sommaVoti2" . $i} / ${"numVoti2" . $i}; ?>
                                                <b>Secondo Periodo (Media: <?= round($media2, 2) ?>)</b> <br>

                                                <!-- lista voti -->
                                                <?php for ($j = 0; $j < count(${"listaVoti2" . $i}); $j++) { ?>
                                                    <a class="btn-floating <?= coloreVoto(${"listaVoti2" . $i}[$j]['decValore']) ?>">
                                                        <i><?= ${"listaVoti2" . $i}[$j]['codVoto'] ?></i>
                                                    </a>
                                                <?php } ?>

                                            </div>

                                            <!-- PRIMO PERIODO -->
                                            <div class="col s6">
                                                <!-- media -->
                                                <?php $media1 = ${"sommaVoti1" . $i} / ${"numVoti1" . $i}; ?>
                                                <b>Primo Periodo (Media: <?= round($media1, 2) ?>)</b> <br>

                                                <!-- lista voti -->
                                                <?php for ($j = 0; $j < count(${"listaVoti1" . $i}); $j++) { ?>
                                                    <a class="btn-floating <?= coloreVoto(${"listaVoti1" . $i}[$j]['decValore']) ?>">
                                                        <i><?= ${"listaVoti1" . $i}[$j]['codVoto'] ?></i>
                                                    </a>
                                                <?php } ?>

                                            </div>


                                        </div>

                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.5/chartjs-plugin-annotation.js"></script>

                <script>
                    // Grafico andamennto scolastico
                    var canvasAndamento = document.getElementById('canvasAndamentoScolastico').getContext('2d');

                    var dataAndamento = {
                        datasets: [{
                            data: [
                                <?php
                                for ($x = 0; $x < count($voti); $x++) {
                                    if ($voti[$x]['decValore'] != 0) {
                                        echo ($voti[$x]['decValore'] . ',');
                                    }
                                }
                                ?>
                            ],
                            fill: false,
                            backgroundColor: 'rgb(255, 159, 64)',
                            borderColor: 'rgb(255, 205, 86)'
                        }],
                        labels: [
                            <?php
                            for ($x = 0; $x < count($voti); $x++) {
                                if ($voti[$x]['decValore'] != 0) {
                                    echo ("'" . $voti[$x]['desMateria'] . "',");
                                }
                            }
                            ?>
                        ]
                    };

                    var grafAndamento = new Chart(canvasAndamento, {
                        type: 'line',
                        data: dataAndamento,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    display: false
                                }],
                                yAxes: [{
                                    display: true
                                }],
                            },
                            elements: {
                                line: {
                                    tension: 0
                                }
                            },
                            annotation: {
                                annotations: [{
                                    drawTime: "afterDatasetsDraw",
                                    type: "line",
                                    mode: "horizontal",
                                    scaleID: "y-axis-0",
                                    value: 6,
                                    borderColor: "rgb(212, 55, 73)",
                                    borderWidth: 2,
                                }]
                            }
                        }
                    });


                    // Grafici medie periodi
                    var canvasMediaComp = document.getElementById('canvasMediaComplessiva').getContext('2d');
                    var canvasMediaTrim = document.getElementById('canvasMediaTrimestre').getContext('2d');
                    var canvasMediaPent = document.getElementById('canvasMediaPentamestre').getContext('2d');

                    var dataMediaComp = {
                        datasets: [{
                            data: [
                                <?= $mediaTot . ',' . (10 - $mediaTot) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaTot) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media complessiva',
                            'Restante'
                        ]
                    };

                    var dataMediaTrim = {
                        datasets: [{
                            data: [
                                <?= $mediaTri . ',' . (10 - $mediaTri) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaTri) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media Trimetre',
                            'Restante'
                        ]
                    };

                    var dataMediaPent = {
                        datasets: [{
                            data: [
                                <?= $mediaPen . ',' . (10 - $mediaPen) ?>
                            ],
                            backgroundColor: [
                                'rgb(<?= coloreGrafico($mediaPen) ?>)',
                                'rgb(161, 161, 161)',
                            ]
                        }],
                        labels: [
                            'Media Pentamentre',
                            'Restante'
                        ]
                    };

                    var grafMediaComp = new Chart(canvasMediaComp, {
                        type: 'doughnut',
                        data: dataMediaComp,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });

                    var grafMediaTrim = new Chart(canvasMediaTrim, {
                        type: 'doughnut',
                        data: dataMediaTrim,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });

                    var grafMediaPent = new Chart(canvasMediaPent, {
                        type: 'doughnut',
                        data: dataMediaPent,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            }
                        }
                    });
                </script>

            </div>
        </div>

    </div>
</main>

<?php include './components/footer.php'; ?>
