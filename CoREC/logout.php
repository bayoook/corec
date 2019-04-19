<?php
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION["id_edit"]);
    header("Location: index");
