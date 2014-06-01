<?php
/**
 * Created by PhpStorm.
 * User: Malte
 * Date: 31.05.14
 * Time: 19:22
 */

namespace Caldera\CriticalmassHeatmapBundle\Utility;

class GPXConverter
{
    protected $gpxFileContent;
    protected $gpxXML;

    public function loadContentFromFile($filename)
    {
        $this->gpxFileContent = file_get_contents($filename);
    }

    public function loadContentFromString($content)
    {
        $this->gpxFileContent = $content;
    }

    public function parseContent()
    {
        $this->gpxXML = new \SimpleXMLElement($this->gpxFileContent);
    }

    public function getPathArray()
    {
        $pathArray = array();

        $startPosition = null;
        $endPosition = null;

        foreach ($this->gpxXML->trk->trkseg as $trksg)
        {
            foreach ($trksg as $trackPoint)
            {
                if ($startPosition == null)
                {
                    $startPosition = new Position((float) $trackPoint['lat'], (float) $trackPoint['lon']);
                }
                else
                {
                    $endPosition = new Position((float) $trackPoint['lat'], (float) $trackPoint['lon']);

                    $path = new Path($startPosition, $endPosition);

                    $pathArray[$path->getHash()] = $path;

                    $startPosition = $endPosition;
                }

            }
        }

        sort($pathArray);

        return $pathArray;
    }
}