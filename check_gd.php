<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
    exit(0);
} else {
    exit(1);
}
