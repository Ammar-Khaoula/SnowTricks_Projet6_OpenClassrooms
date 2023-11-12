<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EmbedVideo extends AbstractExtension
{
    private $iframe;

    public function getFunctions()
    {
        return [
            new TwigFunction('embed_video', [$this, 'embedVideo']),
        ];
    }

    /**
     * Format an iframe for Youtube or Dailymotion embed video
     *
     * @param string $name
     *
     * @return string
     */
    public function embedVideo(string $name): string
    {
        $parsedUrl = parse_url($name);

        if ($parsedUrl['host'] === 'youtu.be') {
            $this->iframe = '<iframe class="col-12" width="140px" height="160px" src="https://www.youtube.com/embed' . $parsedUrl['path']  . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        } else {
            $this->iframe = '<iframe class="col-12" frameborder="0" width="140" height="160" src="https://www.dailymotion.com/embed/video' . $parsedUrl['path']  . '"allowfullscreen allow="autoplay; fullscreen; picture-in-picture"></iframe>';
        }

        return $this->iframe;
    }
}