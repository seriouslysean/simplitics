<?php
if (!defined('ABSPATH')) exit;
$trackingCode = $this->getOption('trackingcode');
if ($trackingCode)
    echo PHP_EOL.$trackingCode.PHP_EOL;
