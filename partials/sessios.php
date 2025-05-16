<?php

session_start();
echo "welcome" . $_SESSION['username'];
echo "<br> your cat is " . $_SESSION['favcat'];
