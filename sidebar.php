<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <?php
            if (isAdmin()) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <span class="fa fa-home"></span> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="timetables.php">
                        <span class="fa fa-calendar-alt"></span> Timetable </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">
                        <span class="fa fa-building"></span> Departments </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="programs.php">
                        <span class="fa fa-sitemap"></span> Programs </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modules.php">
                        <span class="fa fa-tasks"></span> Modules </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">
                        <span class="fa fa-box"></span> Rooms </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lecturers.php">
                        <span class="fa fa-user-md"></span> Lecturers </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="students.php">
                        <span class="fa fa-users"></span> Students </a>
                </li>
                <?php
            } elseif (isLecturer() || isStudent()) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="timetables.php">
                        <span class="fa fa-calendar-alt"></span> Timetable </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>