<?php

class Xml
{
    protected $xml;
    protected $headerTable = array();
    protected $rowTable = array();

    public function __construct()
    {
        $this->xml = @simplexml_load_file('./viviendas.xml');
        //var_dump($this->xml);
    }

    public function td($value)
    {
        return "<td>$value</td>";
    }

    public function th($getname)
    {
        return "<th>$getname</th>";
    }

    public function buildElementsTable($val = null, $tipo)
    {
        switch ($tipo) {
            case 'th':
                if (!in_array($this->th($val), $this->headerTable)) {
                    array_push($this->headerTable, $this->th($val));
                }
                if ($val === null) {
                    return "<tr>" . implode('', $this->headerTable) . "</tr>";
                }
                break;

            case 'tr':
                array_push($this->rowTable, $this->td($val));

                if ($val === null) {
                    return "<tr>" . implode('', $this->rowTable) . "</tr>";
                }
                break;
        }

    }

    public function buildtable()
    {

    }

    public function paintInTable()
    {
        $pepe = false;
        foreach ($this->xml->vivienda as $vivienda) {
            foreach ($vivienda as $value) {
                if ($value->getName() === 'extras') {
                    foreach ($value as $extra) {
                        $this->buildElementsTable($extra->getName(), 'th');
                        $this->buildElementsTable($extra, 'tr');
                    }
                } else {
                    $this->buildElementsTable($value->getName(), 'th');
                    $this->buildElementsTable($value, 'tr');
                }
            }
        };

        //echo $this->buildElementsTable(null, 'th');

        var_dump($this->headerTable);
        var_dump($this->rowTable);

    }

}
