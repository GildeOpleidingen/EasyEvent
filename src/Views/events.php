<?php
use App\Conn;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicons -->
    <link rel="shortcut icon" href="/images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/icons/favicon-16x16.png" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="/images/icons/favicon-32x32.png" type="image/x-icon" sizes="32x32">

    <title>EasyEvents | Events</title>

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/events.css">
    <link rel="stylesheet" href="/css/nav.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid vh-100">
        <?php require_once("./parts/nav.html"); ?>
        
        <!-- tab 1 - Evementenlijst en kalender -->
        <div class="row g-4">
            <!-- Event List -->
            <div class="col-lg-8">
                <div class="nav-buttons d-flex mb-3">
                    <button class="btn btn-primary">All</button>
                    <button class="btn btn-primary">Sports</button>
                    <button class="btn btn-primary">Tourism</button>
                    <button class="btn btn-primary">School</button>
                    <button class="btn btn-primary">Gaming</button>
                </div>

                <!-- Event Items -->
                <div class="event-item" style="background-image: url('../../images/bokkenollen.jpg');">
                    <h3>Bokkenollen</h3>
                    <p>Parcours met bokbier</p>
                    <div class="more-info">
                        <a href="#" class="btn btn-primary">Leer meer <i class="bi bi-chevron-right text-white"></i></a>
                    </div>
                </div>

                <div class="event-item" style="background-image: url('../../images/4daagse.jpg');">
                    <h3>Avondvierdaagse</h3>
                    <p>Enjoy different types of sports. Or even be a part of the event itself, all you gotta do is register yourself.</p>
                    <div class="more-info">
                        <a href="#" class="btn btn-primary">Leer meer <i class="bi bi-chevron-right text-white"></i></a>
                    </div>
                </div>

                <div class="event-item" style="background-image: url('../../images/music.jpg');">
                    <h3>Muziek</h3>
                    <p>Experience music events performed by great musical artists or even be part of the event itself by registering yourself.</p>
                    <div class="more-info">
                        <a href="#" class="btn btn-primary">Leer meer <i class="bi bi-chevron-right text-white"></i></a>
                    </div>
                </div>

                <div class="event-item" style="background-image: url('../../images/tourism.jpg');">
                    <h3>Tourism</h3>
                    <p>Experience tourism events for a memorable time exploring various destinations and cultures.</p>
                    <div class="more-info">
                        <a href="#" class="btn btn-primary">Leer meer <i class="bi bi-chevron-right text-white"></i></a>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="col-lg-4">
                <div class="calendar p-3">
                    <div class="calendar-header d-flex justify-content-between align-items-center">
                        <button class="btn btn-outline-light btn-sm">&lt;</button>
                        <h3 class="px-2">September 2024</h3>
                        <button class="btn btn-outline-light btn-sm">&gt;</button>
                    </div>
                    <?php //echo date('D', strtotime(date('Y-m-01')));?>
                    <table class="calendar-grid mt-4">
                        <tr>
                            <th>ma</th>
                            <th>di</th>
                            <th>wo</th>
                            <th>do</th>
                            <th>vr</th>
                            <th>za</th>
                            <th>zo</th>
                        </tr>
                        <tr>
                            <td><div class="calendar-day">1</div></td>
                            <td><div class="calendar-day">2</div></td>
                            <td><div class="calendar-day">3</div></td>
                            <td><div class="calendar-day">4</div></td>
                            <td><div class="calendar-day">5</div></td>
                            <td><div class="calendar-day">6</div></td>
                            <td><div class="calendar-day">7</div></td>
                        </tr>
                        <tr>
                            <td><div class="calendar-day">8</div></td>
                            <td><div class="calendar-day">9</div></td>
                            <td><div class="calendar-day">10</div></td>
                            <td><div class="calendar-day">11</div></td>
                            <td><div class="calendar-day">12</div></td>
                            <td><div class="calendar-day">13</div></td>
                            <td><div class="calendar-day">14</div></td>
                        </tr>
                        <tr>
                            <td><div class="calendar-day">15</div></td>
                            <td><div class="calendar-day">16</div></td>
                            <td><div class="calendar-day">17</div></td>
                            <td><div class="calendar-day">18</div></td>
                            <td><div class="calendar-day">19</div></td>
                            <td><div class="calendar-day">20</div></td>
                            <td><div class="calendar-day">21</div></td>
                        </tr>
                        <tr>
                            <td><div class="calendar-day">22</div></td>
                            <td><div class="calendar-day">23</div></td>
                            <td><div class="calendar-day">24</div></td>
                            <td><div class="calendar-day">25</div></td>
                            <td><div class="calendar-day">26</div></td>
                            <td><div class="calendar-day">27</div></td>
                            <td><div class="calendar-day">28</div></td>
                        </tr>
                        <tr>
                            <td><div class="calendar-day">29</div></td>
                            <td><div class="calendar-day">30</div></td>
                            <td><div class="calendar-day">31</div></td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab 3 - Jouw evenementen -->

        <!-- tab 4 - Profiel -->
    </div>

    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://kit.fontawesome.com/a70ad4540c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/animaties.js"></script>
    <script src="../../js/searchbar.js"></script>
    <script src="../../js/tabs.js"></script>
</body>
</html>
