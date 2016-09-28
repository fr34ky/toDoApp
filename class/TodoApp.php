<?php

class TodoApp {
    private $arrayOptions = array(
        'minArrayLength' => 0,
        'maxArrayLength' => 2,
        'subKeyPrefix' => '_'
    ),
        $entry = array();

    public function __construct()
    {
        if(empty($_SESSION) || !isset($_SESSION['toDoEntry'])) {
            $changeKey = mt_rand($this->arrayOptions['minArrayLength'], $this->arrayOptions['maxArrayLength']);
            $changeSubKey = mt_rand($this->arrayOptions['minArrayLength'], ($this->arrayOptions['maxArrayLength']+1));
            $deleteKey = mt_rand($this->arrayOptions['minArrayLength'], $this->arrayOptions['maxArrayLength']);

            $this->create();
            $this->update($changeKey, $changeSubKey);
            $this->delete($deleteKey);
        } else {
            if(isset($_SESSION['toDoEntry']) && !empty($_SESSION['toDoEntry'])) {
                $this->entry = $_SESSION['toDoEntry'];
                $this->show('ToDo-Array erfolgreich <strong>geladen</strong>:');
                unset($_SESSION['toDoEntry']);
            }
        }
    }

    protected function create()
    {
        $this->entry = [
            '0' => array(
                'status' => false
            ),
            '1' => array(
                'status' => false,
                '_0' => array(
                    'status' => false,
                    '_entry00' => '_content_00',
                    '_entry01' => '_content_01',
                    '_entry02' => '_content_02'
                ),
                '_1' => array(
                    'status' => false,
                    '_entry10' => '_content_10',
                    '_entry11' => '_content_11',
                    '_entry12' => '_content_12',
                    '_entry13' => '_content_13'
                ),
                '_2' => array(
                    'status' => false
                )
            ),
            '2' => array(
                'status' => false,
                'entry20' => 'content_20'
            )
        ];

        $this->updateSession();
        $this->show('ToDo-Array erfolgreich <strong>erstellt</strong>:');
    }

    protected function update($elemKey, $elemSubKey)
    {
        $msg = 'Key: '.$elemKey;
        $subKey = $this->arrayOptions['subKeyPrefix'].$elemSubKey;
        if(array_key_exists($elemKey, $this->entry)) {
            if(array_key_exists($subKey, $this->entry[$elemKey])) {
                $this->updateStatus($this->entry[$elemKey][$subKey]);
                $msg .= ', SubKey: '.$subKey;
            } else {
                $this->updateStatus($this->entry[$elemKey]);
            }
            $this->updateSession();
            $this->show('ToDo-Array erfolgreich <strong>aktualisiert</strong> ('.$msg.'):');
        } else {
            exit('Element existiert nicht im ToDo-Array');
        }
    }

    protected function delete($elemKey)
    {
        unset($this->entry[$elemKey]);
        $this->show('Key '.$elemKey.' im ToDo-Array erfolgreich <strong>gelöscht</strong>:');
        $this->entry = array_merge(array(), $this->entry);
        $this->updateSession();
        $this->show('im ToDo-Array Keys erfolgreich <strong>aktualisiert</strong>:');
    }

    protected function show($msg)
    {
        echo $msg.'<br /><pre>';
        print_r($this->entry);
        echo '</pre>';
    }

    private function updateStatus(array &$elem) {
        if(!empty($elem)) {
            foreach($elem AS $key => &$value) {
                if($key == 'status') {
                    $value = true;
                }

                if(is_array($value)) {
                    $this->updateStatus($value);
                }
            }
        }
    }

    private function updateSession() {
        $_SESSION['toDoEntry'] = $this->entry;
    }
}
