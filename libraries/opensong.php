<?php

@ob_end_clean();
ob_start();

class OpenSong {
    private $_chord_sharp = array('C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B');
    private $_chord_flat = array('C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B');
    private $_chord = array();

    public function parse($text = '', $transposeInterval = 0, $key = 'sharp') {
        $content = '';
        $text = nl2br($text);
        $arr = array();
        $html = '';
        $content = explode('<br />', $text);
        $columns = 1;
        foreach ($content as $line) {
            $result = trim($line);
            if (empty($result))
                continue;
            else
                $line = trim($line);

            if($line[0] == '-')
                $columns++;
        }
        if($columns >1){
            $width = (int) 100/2;
            $html .= '<div style="float:left;position;absolute;width:' . (int) $width . '%">';
        }
        $html .= '<div style="position:relative;float:left;line-height: 4px;">';

        foreach ($content as $line) {
            $result = trim($line);
            if (empty($result))
                continue;
            else
                $line = trim($line);
            switch ($line[0]) {
                case ' ':
                    $html .= substr($line, 0);
                    $html .= '<br/>';
                    break;
                case '.':
                    $html .= '<b>' . $this->transpose(substr($line, 1), $transposeInterval, $key) . '</b>';
                    $html .= '<br/>';
                    break;
                case '[':
                    $html .= '<div style="margin-top:5px; margin-bottom:5px;display:block;padding:2px 2px 2px 0;">
                            <span style="border:2px solid brown;border-radius:5px;margin-top:2px;width:auto;padding:2px;color:brown;font-weight:bold;padding:0;margin:0;">'
                            . substr($line, 2, strlen($line) - 3)
                            . '</span>'
                            . '</div>';
                    break;
                case '
                    ':
                    $html .= substr($line, 0);
                    $html .= '<br/>';
                    break;
                case '-':
                     $with = (int) 100/$columns;
                    $html .='</div></div>'.'<div style="float:left;position;absolute;width:'. (int) $width. '%">'
                    .'<div style="position:relative;float:left;line-height: 4px;">';
                    break;
                default:
                    $html .= substr($line, 0);
                    $html .= '<br/>';
                    break;
            }
        }
        $html .= '</div></div>';
        return $html;
    }

    private function getChord($chord = '') {
        if (strlen($chord) > 1 && isset($chord[1]) && ($chord[1] == '#' || $chord[1] == 'b')) {
            $array_slice = substr($chord, 2, strlen($chord) - 1);
            if (!$array_slice)
                $array_slice = '';
            return array($chord[0] . $chord[1], $array_slice);
        } else {
            $array_slice = substr($chord, 1, strlen($chord));
            return array($chord[0], $array_slice);
        }
    }

    private function transpose($line, $interval, $using = 'sharp') {
        $new_line = '';
        $interval = ($interval < 0) ? 12 + $interval : $interval;
        $this->_chord = ($using == 'sharp') ? $this->_chord_sharp : $this->_chord_flat;

        $temp = "";
        $arr = array();

        for ($e = 0; $e < strlen($line); $e++) {
            if ($line[$e] == ' ' || $line[$e] == '' || $line[$e] == '&nbsp;')
                $arr[] = ' ';
            else {
                $temp .= $line[$e];
                if (isset($line[$e + 1]) && $line[$e + 1] == ' ') {
                    $arr[] = $temp;
                    $temp = "";
                } elseif (!isset($line[$e + 1])) {
                    $arr[] = $temp;
                    $temp = "";
                }
            }
        }

        $chord = $arr;

        for ($a = 0; $a < sizeof($chord); $a++) {
            $char = $chord[$a];
            if (isset($char[0]))
                $char_ord = ord($char[0]);

            if ($char == '' || $char == ' ') {
                $new_line .='&nbsp;';
                continue;
            }

            if ($char_ord == 45) {
                $new_line .='-';
                continue;
            }

            if (($char[0] >= 'A' && $char[0] <= 'G' ) || ($char[0] >= 'a' && $char[0] <= 'g' )) {
                $temp = $this->getChord($char);

                $keySharp = array_search(ucfirst(strtolower($temp[0])), $this->_chord_sharp);
                $keyFlat = array_search(ucfirst(strtolower($temp[0])), $this->_chord_flat);

                if ($keySharp == '')
                    $key = $keyFlat;
                else
                    $key = $keySharp;

                $new_line .= (($key + $interval) > 11 ) ? $this->_chord[$key + $interval - 12] : $this->_chord[$key + $interval];
                $new_line .= $temp[1];
            }
        }

        return $new_line;
    }

}