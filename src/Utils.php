<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */

final class Utils
{
    static public function printMessage($message): string
    {
        return $message->getText();
    }

    static public function printMessages($messages): string
    {
        $res = "";
        foreach ($messages as $message) {
            $res = $res . Utils::printMessage($message) . "\n";
        }
        return $res;
    }
}
?>
