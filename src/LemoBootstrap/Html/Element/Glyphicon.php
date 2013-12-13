<?php

namespace LemoBootstrap\Html\Element;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\Element;
use LemoBootstrap\Html\ElementInterface;
use Traversable;

class Glyphicon extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'class' => 'glyphicon',
    );

    /**
     * Valid values for the button type
     *
     * @var array
     */
    protected $validIcons = array(
        'adjust'                 => true,
        'align-center'           => true,
        'align-justify'          => true,
        'align-left'             => true,
        'arrow-down'             => true,
        'arrow-left'             => true,
        'arrow-right'            => true,
        'arrow-up'               => true,
        'asterisk'               => true,
        'backward'               => true,
        'ban-circle'             => true,
        'barcode'                => true,
        'bell'                   => true,
        'bold'                   => true,
        'book'                   => true,
        'bookmark'               => true,
        'briefcase'              => true,
        'bullhorn'               => true,
        'calendar'               => true,
        'camera'                 => true,
        'certificate'            => true,
        'check'                  => true,
        'chevron-down'           => true,
        'chevron-left'           => true,
        'chevron-right'          => true,
        'chevron-up'             => true,
        'circle-arrow-down'      => true,
        'circle-arrow-left'      => true,
        'circle-arrow-right'     => true,
        'circle-arrow-up'        => true,
        'cloud'                  => true,
        'cloud-download'         => true,
        'cloud-upload'           => true,
        'cog'                    => true,
        'collapse-down'          => true,
        'collapse-up'            => true,
        'comment'                => true,
        'compressed'             => true,
        'copyright-mark'         => true,
        'credit-card'            => true,
        'cutlery'                => true,
        'dashboard'              => true,
        'download'               => true,
        'download-alt'           => true,
        'earphone'               => true,
        'edit'                   => true,
        'eject'                  => true,
        'envelope'               => true,
        'euro'                   => true,
        'exclamation-sign'       => true,
        'expand'                 => true,
        'export'                 => true,
        'eye-close'              => true,
        'eye-open'               => true,
        'facetime-video'         => true,
        'fast-backward'          => true,
        'fast-forward'           => true,
        'file'                   => true,
        'film'                   => true,
        'filter'                 => true,
        'fire'                   => true,
        'flag'                   => true,
        'flash'                  => true,
        'floppy-disk'            => true,
        'floppy-open'            => true,
        'floppy-remove'          => true,
        'floppy-save'            => true,
        'floppy-saved'           => true,
        'folder-close'           => true,
        'folder-open'            => true,
        'font'                   => true,
        'forward'                => true,
        'fullscreen'             => true,
        'gbp'                    => true,
        'gift'                   => true,
        'glass'                  => true,
        'globe'                  => true,
        'hand-down'              => true,
        'hand-left'              => true,
        'hand-right'             => true,
        'hand-up'                => true,
        'hd-video'               => true,
        'hdd'                    => true,
        'header'                 => true,
        'headphones'             => true,
        'heart'                  => true,
        'heart-empty'            => true,
        'home'                   => true,
        'import'                 => true,
        'inbox'                  => true,
        'indent-left'            => true,
        'indent-right'           => true,
        'info-sign'              => true,
        'italic'                 => true,
        'leaf'                   => true,
        'link'                   => true,
        'list'                   => true,
        'list-alt'               => true,
        'lock'                   => true,
        'log-in'                 => true,
        'log-out'                => true,
        'magnet'                 => true,
        'map-marker'             => true,
        'minus'                  => true,
        'minus-sign'             => true,
        'move'                   => true,
        'music'                  => true,
        'new-window'             => true,
        'off'                    => true,
        'ok'                     => true,
        'ok-circle'              => true,
        'ok-sign'                => true,
        'open'                   => true,
        'paperclip'              => true,
        'pause'                  => true,
        'pencil'                 => true,
        'phone'                  => true,
        'phone-alt'              => true,
        'picture'                => true,
        'plane'                  => true,
        'play'                   => true,
        'play-circle'            => true,
        'plus'                   => true,
        'plus-sign'              => true,
        'print'                  => true,
        'pushpin'                => true,
        'qrcode'                 => true,
        'question-sign'          => true,
        'random'                 => true,
        'record'                 => true,
        'refresh'                => true,
        'registration-mark'      => true,
        'remove'                 => true,
        'remove-circle'          => true,
        'remove-sign'            => true,
        'repeat'                 => true,
        'resize-full'            => true,
        'resize-horizontal'      => true,
        'resize-small'           => true,
        'resize-vertical'        => true,
        'retweet'                => true,
        'road'                   => true,
        'save'                   => true,
        'saved'                  => true,
        'screenshot'             => true,
        'sd-video'               => true,
        'search'                 => true,
        'send'                   => true,
        'share'                  => true,
        'share-alt'              => true,
        'shopping-cart'          => true,
        'signal'                 => true,
        'sort'                   => true,
        'sort-by-alphabet'       => true,
        'sort-by-alphabet-alt'   => true,
        'sort-by-attributes'     => true,
        'sort-by-attributes-alt' => true,
        'sort-by-order'          => true,
        'sort-by-order-alt'      => true,
        'sound-5-1'              => true,
        'sound-6-1'              => true,
        'sound-7-1'              => true,
        'sound-dolby'            => true,
        'sound-stereo'           => true,
        'star'                   => true,
        'star-empty'             => true,
        'stats'                  => true,
        'step-backward'          => true,
        'step-forward'           => true,
        'stop'                   => true,
        'subtitles'              => true,
        'tag'                    => true,
        'tags'                   => true,
        'tasks'                  => true,
        'text-height'            => true,
        'text-width'             => true,
        'th'                     => true,
        'th-larg'                => true,
        'th-list'                => true,
        'thumbs-down'            => true,
        'thumbs-up'              => true,
        'time'                   => true,
        'tint'                   => true,
        'tower'                  => true,
        'transfer'               => true,
        'trash'                  => true,
        'tree-conifer'           => true,
        'tree-deciduous'         => true,
        'unchecked'              => true,
        'upload'                 => true,
        'usd'                    => true,
        'user'                   => true,
        'volume-down'            => true,
        'volume-off'             => true,
        'volume-up'              => true,
        'warning-sign'           => true,
        'wrench'                 => true,
        'zoom-in'                => true,
        'zoom-out'               => true,
    );

    /**
     * Glyphicon name
     *
     * @var string
     */
    protected $icon;

    /**
     * Set glyphicon name
     *
     * @param string $icon
     * @return Glyphicon
     * @throws Exception\InvalidArgumentException
     */
    public function setIcon($icon)
    {
        $icon = strtolower($icon);
        if (!isset($this->validIcons[$icon])) {
            throw new Exception\InvalidArgumentException("Unsupported icon '{$icon}' given");
        }

        $this->icon = $icon;
        return $this;
    }

    /**
     * Retreive glyphicon name
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set options for an element. Accepted options are:
     * - icon: icon name
     *
     * @param  array|Traversable $options
     * @return Glyphicon|ElementInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($this->options['icon'])) {
            $this->setIcon($this->options['icon']);
        }

        return $this;
    }
}
