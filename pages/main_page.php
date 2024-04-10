<?php

include_once('template/common.tlp.php');

function drawMainPage() {
    createPage(function () {
        drawMainHeader();
        drawFooter();
    });
}