<?php

namespace LemoBootstrap\Html\Element;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\Element;
use LemoBootstrap\Html\ElementInterface;
use Traversable;

class FontAwesome extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'class' => '',
    );

    /**
     * Has icon fixed width?
     *
     * @var bool
     */
    protected $fixedWidth = false;

    /**
     * Glyphicon name
     *
     * @var string
     */
    protected $icon;

    /**
     * Valid values for the button type
     *
     * @var array
     */
    protected $icons = array(
        'adjust'                 => 'adjust',
        'align-center'           => 'align-center',
        'align-justify'          => 'align-justify',
        'align-left'             => 'align-left',
        'align-right'            => 'align-right',
        'ambulance'              => 'ambulance',
        'anchor'                 => 'anchor',
        'angle-double-down'      => 'angle-double-down',
        'angle-double-left'      => 'angle-double-left',
        'angle-double-right'     => 'angle-double-right',
        'angle-double-up'        => 'angle-double-up',
        'angle-down'             => 'angle-down',
        'angle-left'             => 'angle-left',
        'angle-right'            => 'angle-right',
        'angle-up'               => 'angle-up',
        'archive'                => 'archive',
        'area-chart'             => 'area-chart',
        'arrow-circle-down'      => 'arrow-circle-down',
        'arrow-circle-left'      => 'arrow-circle-left',
        'arrow-circle-o-down'    => 'arrow-circle-o-down',
        'arrow-circle-o-left'    => 'arrow-circle-o-left',
        'arrow-circle-o-right'   => 'arrow-circle-o-right',
        'arrow-circle-o-up'      => 'arrow-circle-o-up',
        'arrow-circle-right'     => 'arrow-circle-right',
        'arrow-circle-up'        => 'arrow-circle-up',
        'arrow-down'             => 'arrow-down',
        'arrow-left'             => 'arrow-left',
        'arrow-right'            => 'arrow-right',
        'arrow-up'               => 'arrow-up',
        'arrows'                 => 'arrows',
        'arrows-alt'             => 'arrows-alt',
        'arrows-h'               => 'arrows-h',
        'arrows-v'               => 'arrows-v',
        'asterisk'               => 'asterisk',
        'at'                     => 'at',
        'automobile'             => 'automobile',
        'backward'               => 'backward',
        'balance-scale'          => 'balance-scale',
        'ban'                    => 'ban',
        'bank'                   => 'bank',
        'bar-chart'              => 'bar-chart',
        'bar-chart-o'            => 'bar-chart-o',
        'barcode'                => 'barcode',
        'bars'                   => 'bars',
        'battery-0'              => 'battery-0',
        'battery-1'              => 'battery-1',
        'battery-2'              => 'battery-2',
        'battery-3'              => 'battery-3',
        'battery-4'              => 'battery-4',
        'battery-empty'          => 'battery-empty',
        'battery-full'           => 'battery-full',
        'battery-half'           => 'battery-half',
        'battery-quarter'        => 'battery-quarter',
        'battery-three-quarters' => 'battery-three-quarters',
        'bed'                    => 'bed',
        'beer'                   => 'beer',
        'bell'                   => 'bell',
        'bell-o'                 => 'bell-o',
        'bell-slash'             => 'bell-slash',
        'bell-slash-o'           => 'bell-slash-o',
        'bicycle'                => 'bicycle',
        'binoculars'             => 'binoculars',
        'birthday-cake'          => 'birthday-cake',
        'bitcoin'                => 'bitcoin',
        'bold'                   => 'bold',
        'bolt'                   => 'bolt',
        'book'                   => 'book',
        'bookmark'               => 'bookmark',
        'bookmark-o'             => 'bookmark-o',
        'briefcase'              => 'briefcase',
        'btc'                    => 'btc',
        'bug'                    => 'bug',
        'building'               => 'building',
        'building-o'             => 'building-o',
        'bullhorn'               => 'bullhorn',
        'bullseys'               => 'bullseys',
        'bus'                    => 'bus',
        'cab'                    => 'cab',
        'calculator'             => 'calculator',
        'calendar'               => 'calendar',
        'calendar-minus-o'       => 'calendar-minus-o',
        'calendar-o'             => 'calendar-o',
        'calendar-plus-o'        => 'calendar-plus-o',
        'calendar-times-o'       => 'calendar-times-o',
        'camera'                 => 'camera',
        'camera-retro'           => 'camera-retro',
        'car'                    => 'car',
        'caret-down'             => 'caret-down',
        'caret-left'             => 'caret-left',
        'caret-right'            => 'caret-right',
        'caret-square-o-down'    => 'caret-square-o-down',
        'caret-square-o-left'    => 'caret-square-o-left',
        'caret-square-o-right'   => 'caret-square-o-right',
        'caret-square-o-up'      => 'caret-square-o-up',
        'caret-up'               => 'caret-up',
        'cart-arrow-down'        => 'cart-arrow-down',
        'cart-plus'              => 'cart-plus',
        'cc'                     => 'cc',
        'cc-amex'                => 'cc-amex',
        'cc-diners-club'         => 'cc-diners-club',
        'cc-discover'            => 'cc-discover',
        'cc-jcb'                 => 'cc-jcb',
        'cc-mastercard'          => 'cc-mastercard',
        'cc-paypal'              => 'cc-paypal',
        'cc-stripe'              => 'cc-stripe',
        'cc-visa'                => 'cc-visa',
        'certificate'            => 'certificate',
        'chain'                  => 'chain',
        'chain-broken'           => 'chain-broken',
        'check'                  => 'check',
        'check-circle'           => 'check-circle',
        'check-circle-o'         => 'check-circle-o',
        'check-square'           => 'check-square',
        'check-square-o'         => 'check-square-o',
        'chevron-circle-down'    => 'chevron-circle-down',
        'chevron-circle-left'    => 'chevron-circle-left',
        'chevron-circle-right'   => 'chevron-circle-right',
        'chevron-circle-up'      => 'chevron-circle-up',
        'chevron-down'           => 'chevron-down',
        'chevron-left'           => 'chevron-left',
        'chevron-right'          => 'chevron-right',
        'chevron-up'             => 'chevron-up',
        'child'                  => 'child',
        'circle'                 => 'circle',
        'circle-o'               => 'circle-o',
        'circle-o-notch'         => 'circle-o-notch',
        'circle-thin'            => 'circle-thin',
        'clipboard'              => 'clipboard',
        'clock-o'                => 'clock-o',
        'clone'                  => 'clone',
        'close'                  => 'close',
        'cloud'                  => 'cloud',
        'cloud-download'         => 'cloud-download',
        'cloud-upload'           => 'cloud-upload',
        'code'                   => 'code',
        'code-fork'              => 'code-fork',
        'coffee'                 => 'coffee',
        'cog'                    => 'cog',
        'cogs'                   => 'cogs',
        'columns'                => 'columns',
        'comment'                => 'comment',
        'comment-o'              => 'comment-o',
        'commenting'             => 'commenting',
        'comments'               => 'comments',
        'comments-o'             => 'comments-o',
        'compass'                => 'compass',
        'compress'               => 'compress',
        'cny'                    => 'cny',
        'copy'                   => 'copy',
        'copyright'              => 'copyright',
        'creative-commons'       => 'creative-commons',
        'credit-card'            => 'credit-card',
        'crop'                   => 'crop',
        'crosshairs'             => 'crosshairs',
        'cube'                   => 'cube',
        'cubes'                  => 'cubes',
        'cut'                    => 'cut',
        'cutlery'                => 'cutlery',
        'dashboard'              => 'dashboard',
        'database'               => 'database',
        'dedent'                 => 'dedent',
        'desktop'                => 'desktop',
        'diamond'                => 'diamond',
        'dollar'                 => 'dollar',
        'dot-circle-o'           => 'dot-circle-o',
        'download'               => 'download',
        'edit'                   => 'edit',
        'eject'                  => 'eject',
        'ellipsis-h'             => 'ellipsis-h',
        'ellipsis-v'             => 'ellipsis-v',
        'envelope'               => 'envelope',
        'envelope-o'             => 'envelope-o',
        'envelope-square'        => 'envelope-square',
        'eraser'                 => 'eraser',
        'eur'                    => 'eur',
        'euro'                   => 'euro',
        'exchange'               => 'exchange',
        'exclamation'            => 'exclamation',
        'exclamation-circle'     => 'exclamation-circle',
        'exclamation-triangle'   => 'exclamation-triangle',
        'external-link'          => 'external-link',
        'external-link-square'   => 'external-link-square',
        'expand'                 => 'expand',
        'eye'                    => 'eye',
        'eye-slash'              => 'eye-slash',
        'eyedropper'             => 'eyedropper',
        'fast-backward'          => 'fast-backward',
        'fast-forward'           => 'fast-forward',
        'fax'                    => 'fax',
        'feed'                   => 'feed',
        'female'                 => 'female',
        'fighter-jet'            => 'fighter-jet',
        'file'                   => 'file',
        'file-archive-o'         => 'file-archive-o',
        'file-audio-o'           => 'file-audio-o',
        'file-code-o'            => 'file-code-o',
        'file-excel-o'           => 'file-excel-o',
        'file-image-o'           => 'file-image-o',
        'file-movie-o'           => 'file-movie-o',
        'file-o'                 => 'file-o',
        'file-pdf-o'             => 'file-pdf-o',
        'file-photo-o'           => 'file-photo-o',
        'file-picture-o'         => 'file-picture-o',
        'file-powerpoint-o'      => 'file-powerpoint-o',
        'file-sound-o'           => 'file-sound-o',
        'file-text'              => 'file-text',
        'file-text-o'            => 'file-text-o',
        'file-video-o'           => 'file-video-o',
        'file-word-o'            => 'file-word-o',
        'file-zip-o'             => 'file-zip-o',
        'files-o'                => 'files-o',
        'film'                   => 'film',
        'filter'                 => 'filter',
        'fire'                   => 'fire',
        'fire-extinguisher'      => 'fire-extinguisher',
        'flag'                   => 'flag',
        'flag-checkered'         => 'flag-checkered',
        'flag-o'                 => 'flag-o',
        'flash'                  => 'flash',
        'flask'                  => 'flask',
        'floppy-o'               => 'floppy-o',
        'folder'                 => 'folder',
        'folder-o'               => 'folder-o',
        'folder-open'            => 'folder-open',
        'folder-open-o'          => 'folder-open-o',
        'font'                   => 'font',
        'forward'                => 'forward',
        'frown-o'                => 'frown-o',
        'futbol-o'               => 'futbol-o',
        'gamepad'                => 'gamepad',
        'gavel'                  => 'gavel',
        'gbp'                    => 'gbp',
        'gear'                   => 'gear',
        'gears'                  => 'gears',
        'genderless'             => 'genderless',
        'gift'                   => 'gift',
        'glass'                  => 'glass',
        'globe'                  => 'globe',
        'gg'                     => 'gg',
        'gg-circle'              => 'gg-circle',
        'google-wallet'          => 'google-wallet',
        'graduation-cap'         => 'graduation-cap',
        'group'                  => 'group',
        'hand-grab-o'            => 'hand-grab-o',
        'hand-lizard-o'          => 'hand-lizard-o',
        'hand-o-down'            => 'hand-o-down',
        'hand-o-left'            => 'hand-o-left',
        'hand-o-right'           => 'hand-o-right',
        'hand-o-up'              => 'hand-o-up',
        'hand-paper-o'           => 'hand-paper-o',
        'hand-peace-o'           => 'hand-peace-o',
        'hand-pointer-o'         => 'hand-pointer-o',
        'hand-rock-o'            => 'hand-rock-o',
        'hand-scissors-o'        => 'hand-scissors-o',
        'hand-spock-o'           => 'hand-spock-o',
        'hand-stop-o'            => 'hand-stop-o',
        'hdd-o'                  => 'hdd-o',
        'header'                 => 'header',
        'headphones'             => 'headphones',
        'heart'                  => 'heart',
        'heart-o'                => 'heart-o',
        'heartbeat'              => 'heartbeat',
        'history'                => 'history',
        'home'                   => 'home',
        'hotel'                  => 'hotel',
        'hourglass'              => 'hourglass',
        'hourglass-1'            => 'hourglass-1',
        'hourglass-2'            => 'hourglass-2',
        'hourglass-3'            => 'hourglass-3',
        'hourglass-end'          => 'hourglass-end',
        'hourglass-half'         => 'hourglass-half',
        'hourglass-o'            => 'hourglass-o',
        'hourglass-start'        => 'hourglass-start',
        'i-cursor'               => 'i-cursor',
        'ils'                    => 'ils',
        'image'                  => 'image',
        'inbox'                  => 'inbox',
        'indent'                 => 'indent',
        'industry'               => 'industry',
        'info'                   => 'info',
        'info-circle'            => 'info-circle',
        'inr'                    => 'inr',
        'institution'            => 'institution',
        'intersex'               => 'intersex',
        'italic'                 => 'italic',
        'jpy'                    => 'jpy',
        'key'                    => 'key',
        'keyboard-o'             => 'keyboard-o',
        'krw'                    => 'krw',
        'language'               => 'language',
        'laptop'                 => 'laptop',
        'leaf'                   => 'leaf',
        'legal'                  => 'legal',
        'lemon-o'                => 'lemon-o',
        'level-down'             => 'level-up',
        'level-up'               => 'level-up',
        'life-bouy'              => 'life-bouy',
        'life-buoy'              => 'life-buoy',
        'life-ring'              => 'life-ring',
        'life-saver'             => 'life-saver',
        'lightbulb-o'            => 'lightbulb-o',
        'line-chart'             => 'line-chart',
        'link'                   => 'link',
        'list'                   => 'list',
        'list-alt'               => 'list-alt',
        'list-ol'                => 'list-ol',
        'list-ul'                => 'list-ul',
        'location-arrow'         => 'location-arrow',
        'lock'                   => 'lock',
        'long-arrow-down'        => 'long-arrow-down',
        'long-arrow-left'        => 'long-arrow-left',
        'long-arrow-right'       => 'long-arrow-right',
        'long-arrow-up'          => 'long-arrow-up',
        'magic'                  => 'magic',
        'magnet'                 => 'magnet',
        'mail-forward'           => 'mail-forward',
        'mail-reply'             => 'mail-reply',
        'mail-reply-all'         => 'mail-reply-all',
        'male'                   => 'male',
        'map'                    => 'map',
        'map-marker'             => 'map-marker',
        'map-o'                  => 'map-o',
        'map-pin'                => 'map-pin',
        'map-signs'              => 'map-signs',
        'mars'                   => 'mars',
        'mars-double'            => 'mars-double',
        'mars-stroke-h'          => 'mars-stroke-h',
        'mars-stroke-v'          => 'mars-stroke-v',
        'meh-o'                  => 'meh-o',
        'microphone'             => 'microphone',
        'microphone-slash'       => 'microphone-slash',
        'minus'                  => 'minus',
        'minus-circle'           => 'minus-circle',
        'minus-square'           => 'minus-square',
        'minus-square-o'         => 'minus-square-o',
        'mobile'                 => 'mobile',
        'mobile-phone'           => 'mobile-phone',
        'money'                  => 'money',
        'moon-o'                 => 'moon-o',
        'mortar-board'           => 'mortar-board',
        'motorcycle'             => 'motorcycle',
        'mouse-pointer'          => 'mouse-pointer',
        'music'                  => 'music',
        'navicon'                => 'navicon',
        'neuter'                 => 'neuter',
        'newspaper-o'            => 'newspaper-o',
        'object-group'           => 'object-group',
        'object-ungroup'         => 'object-ungroup',
        'outdent'                => 'outdent',
        'paint-brush'            => 'paint-brush',
        'paper-plane'            => 'paper-plane',
        'paper-plane-o'          => 'paper-plane-o',
        'paperclip'              => 'paperclip',
        'paragraph'              => 'paragraph',
        'paste'                  => 'paste',
        'pause'                  => 'pause',
        'paypal'                 => 'paypal',
        'paw'                    => 'paw',
        'pencil'                 => 'pencil',
        'pencil-square'          => 'pencil-square',
        'pencil-square-o'        => 'pencil-square-o',
        'phone'                  => 'phone',
        'phone-square'           => 'phone-square',
        'photo'                  => 'photo',
        'picture-o'              => 'picture-o',
        'pie-chart'              => 'pie-chart',
        'plane'                  => 'plane',
        'play'                   => 'play',
        'play-circle'            => 'play-circle',
        'play-circle-o'          => 'play-circle-o',
        'plug'                   => 'plug',
        'plus'                   => 'plus',
        'plus-circle'            => 'plus-circle',
        'plus-square'            => 'plus-square',
        'plus-square-o'          => 'plus-square-o',
        'power-off'              => 'power-off',
        'print'                  => 'print',
        'puzzle-piece'           => 'puzzle-piece',
        'qrcode'                 => 'qrcode',
        'question'               => 'question',
        'question-circle'        => 'question-circle',
        'quote-left'             => 'quote-right',
        'quote-right'            => 'quote-right',
        'random'                 => 'random',
        'recycle'                => 'recycle',
        'refresh'                => 'refresh',
        'registred'              => 'registred',
        'remove'                 => 'remove',
        'reorder'                => 'reorder',
        'repeat'                 => 'repeat',
        'reply'                  => 'reply',
        'reply-all'              => 'reply-all',
        'retweet'                => 'retweet',
        'rmb'                    => 'rmb',
        'road'                   => 'road',
        'rocket'                 => 'rocket',
        'rotate-left'            => 'rotate-left',
        'rotate-right'           => 'rotate-right',
        'rouble'                 => 'rouble',
        'rss'                    => 'rss',
        'rss-square'             => 'rss-square',
        'rub'                    => 'rub',
        'ruble'                  => 'ruble',
        'rupee'                  => 'rupee',
        'save'                   => 'save',
        'scissors'               => 'scissors',
        'search'                 => 'search',
        'search-minus'           => 'search-minus',
        'search-plus'            => 'search-plus',
        'send'                   => 'send',
        'send-o'                 => 'send-o',
        'server'                 => 'server',
        'share'                  => 'share',
        'share-alt'              => 'share-alt',
        'share-alt-square'       => 'share-alt-square',
        'share-square'           => 'share-square',
        'share-square-o'         => 'share-square-o',
        'shekel'                 => 'shekel',
        'sheqel'                 => 'sheqel',
        'shield'                 => 'shield',
        'ship'                   => 'ship',
        'shopping-cart'          => 'shopping-cart',
        'sign-in'                => 'sign-in',
        'sign-out'               => 'sign-out',
        'signal'                 => 'signal',
        'sitemap'                => 'sitemap',
        'sliders'                => 'sliders',
        'smile-o'                => 'smile-o',
        'soccer-ball-o'          => 'soccer-ball-o',
        'sort'                   => 'sort',
        'sort-alpha-asc'         => 'sort-alpha-asc',
        'sort-alpha-desc'        => 'sort-alpha-desc',
        'sort-amount-asc'        => 'sort-amount-asc',
        'sort-asc'               => 'sort-asc',
        'sort-desc'              => 'sort-desc',
        'sort-down'              => 'sort-down',
        'sort-numeric-asc'       => 'sort-numeric-asc',
        'sort-numeric-desc'      => 'sort-numeric-desc',
        'sort-up'                => 'sort-up',
        'space-shuttle'          => 'space-shuttle',
        'spinner'                => 'spinner',
        'spoon'                  => 'spoon',
        'square'                 => 'square',
        'square-o'               => 'square-o',
        'star'                   => 'star',
        'star-half'              => 'star-half',
        'star-half-empty'        => 'star-half-empty',
        'star-half-full'         => 'star-half-full',
        'star-half-o'            => 'star-half-o',
        'star-o'                 => 'star-o',
        'step-backward'          => 'step-backward',
        'step-forward'           => 'step-forward',
        'sticky-note'            => 'sticky-note',
        'sticky-note-o'          => 'sticky-note-o',
        'stop'                   => 'stop',
        'street-view'            => 'street-view',
        'strikethrough'          => 'strikethrough',
        'subscript'              => 'subscript',
        'subway'                 => 'subway',
        'suitecase'              => 'suitecase',
        'superscript'            => 'superscript',
        'sun-o'                  => 'sun-o',
        'support'                => 'support',
        'table'                  => 'table',
        'tablet'                 => 'tablet',
        'tachometer'             => 'tachometer',
        'tag'                    => 'tag',
        'tags'                   => 'tags',
        'tasks'                  => 'tasks',
        'taxi'                   => 'taxi',
        'television'             => 'television',
        'terminal'               => 'terminal',
        'text-height'            => 'text-height',
        'text-width'             => 'text-width',
        'th'                     => 'th',
        'th-large'               => 'th-large',
        'th-list'                => 'th-list',
        'thumb-tack'             => 'thumb-tack',
        'thumbs-down'            => 'thumbs-down',
        'thumbs-o-down'          => 'thumbs-o-down',
        'thumbs-o-up'            => 'thumbs-o-up',
        'thumbs-up'              => 'thumbs-up',
        'ticket'                 => 'ticket',
        'times'                  => 'times',
        'times-circle'           => 'times-circle',
        'times-circle-o'         => 'times-circle-o',
        'tint'                   => 'tint',
        'toggle-down'            => 'toggle-down',
        'toggle-left'            => 'toggle-left',
        'toggle-off'             => 'toggle-off',
        'toggle-on'              => 'toggle-on',
        'toggle-right'           => 'toggle-right',
        'toggle-up'              => 'toggle-up',
        'trademark'              => 'trademark',
        'train'                  => 'train',
        'transgender'            => 'transgender',
        'transgender-alt'        => 'transgender-alt',
        'trash'                  => 'trash',
        'trash-o'                => 'trash-o',
        'tree'                   => 'tree',
        'trophy'                 => 'trophy',
        'truck'                  => 'truck',
        'try'                    => 'try',
        'tty'                    => 'tty',
        'turkish-lira'           => 'turkish-lira',
        'tv'                     => 'tv',
        'umbrella'               => 'umbrella',
        'underline'              => 'underline',
        'undo'                   => 'undo',
        'university'             => 'university',
        'unlink'                 => 'unlink',
        'unlock'                 => 'unlock',
        'unlock-alt'             => 'unlock-alt',
        'unsorted'               => 'unsorted',
        'upload'                 => 'upload',
        'usd'                    => 'usd',
        'user'                   => 'user',
        'user-plus'              => 'user-plus',
        'user-secret'            => 'user-secret',
        'user-times'             => 'user-times',
        'users'                  => 'users',
        'venus'                  => 'venus',
        'venus-double'           => 'venus-double',
        'venus-mars'             => 'venus-mars',
        'video-camera'           => 'video-camera',
        'volume-down'            => 'volume-down',
        'volume-off'             => 'volume-off',
        'volume-up'              => 'volume-up',
        'warning'                => 'warning',
        'wheelchair'             => 'wheelchair',
        'wifi'                   => 'wifi',
        'won'                    => 'won',
        'wrench'                 => 'wrench',
        'yen'                    => 'yen',
        'youtube-play'           => 'youtube-play',
    );

    /**
     * @var null|int
     */
    protected $size = null;

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

        if (isset($this->options['fixed_width'])) {
            $this->setFixedWidth($this->options['fixed_width']);
        }

        if (isset($this->options['icon'])) {
            $this->setIcon($this->options['icon']);
        }

        if (isset($this->options['size'])) {
            $this->setSize($this->options['size']);
        }

        return $this;
    }

    /**
     * @param  boolean $fixedWidth
     * @return FontAwesome
     */
    public function setFixedWidth($fixedWidth)
    {
        $this->fixedWidth = (bool) $fixedWidth;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getFixedWidth()
    {
        return $this->fixedWidth;
    }

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
        if (!isset($this->icons[$icon])) {
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
     * Return list of icons
     *
     * @return array
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * @param  int|null $size
     * @return FontAwesome
     */
    public function setSize($size)
    {
        if (null !== $size && !in_array($size, array(2,3,4,5))) {
            throw new Exception\InvalidArgumentException("Unsupported size '{$size}' given");
        }

        $this->size = $size;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize()
    {
        return $this->size;
    }
}
