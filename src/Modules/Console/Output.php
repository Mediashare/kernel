<?php
namespace Mediashare\Modules;

/**
 * Output
 */
class Output
{   
    public function progressBar(int $counter, int $max_counter, ?string $message) {
        $climate = new \League\CLImate\CLImate;
        // $climate->clear();
        // Progress Status
        $pourcent = ($counter/$max_counter) * 100;
        if ($pourcent >= 90):
            $climate->green();
        elseif ($pourcent >= 75):
            $climate->lightGreen();
        elseif ($pourcent >= 50):
            $climate->blue();
        else:
            $climate->cyan();        
        endif;
        $progress = $climate->progress()->total($max_counter);        
        $progress->advance($counter, $message);
    }

    /**
     * Color string for output client
     * @param  string $txt
     * @param  string|null $color
     * @return string
     */
    public function echoColor(string $txt, string $color = null) {
        if (!$color) {$idColor = rand(30,37);} else {$idColor = $this->translateColor($color);}
        return "\033[".$idColor."m".$txt."\033[39m";
    }

    public function translateColor(string $color) {
        $tabColor = [
            'black' => '0;30',
            'blue' => '0;34',
            'green' => '0;32',
            'cyan' => '0;36',
            'red' => '0;31',
            'purple' => '0;35',
            'brown' => '0;33',
            'yellow' => '1;33',
            'white' =>  '1;37'
        ];
        return $tabColor[$color];
    }
}
