<?php

namespace App\Model;

/**
 * Localization Dictionary
 *
 * Contains all the translations of the website. This used to be in the database, however, it was in a very... let's say
 * not humanly understandable format and it was pretty annoying to change anything. I was deciding between using config,
 * xml, json and this thing. In the end I decided in favor of this. In theory, any other way could be implemented here,
 * because this class only returns arrays.
 *
 * @package App\Model
 */
class LocalizationDictionary
{
    /** @var array words that can be translated using the localize method */
    private $words = [
        'link-homepage' => ['homepage','domovska-stranka'],
        'link-archive' => ['archive','archiv'],
        'templateWord' => ['english','czech']
    ];
    
    /** @var bool $english whether the page is English or not. Decided in the constructor. */
    private $english;
    
    /**
     * LocalizationDictionary constructor.
     *
     * Decides whether the page is English or not (Czech).
     */
    public function __construct()
    {
        $this->english = (LocaleAM::code() ?? 'en-us') === 'en-us';
    }
    
    
    /**
     * In case something else (ideally short) needs to be translated. It looks through the $words array.
     *
     * @param $word
     * @return bool
     */
    public function searchAndTranslate($word)
    {
        if (isset($this->words[$word]))
            return ($this->english) ? $this->words[$word][0] : $this->words[$word][1];
        return false;
    }
    
    /**
     * Base UI elements, buttons and that kind of stuff.
     *
     * @return array
     */
    public function base()
    {
        return ($this->english) ? [
            'about' => [0 => 'about', 1 => 'About me',],
            'user' => [0 => 'user/login', 1 => 'Login',],
            'website' => [0 => 'about/website', 1 => 'Website',],
            'creator' => [0 => 'about/martin-toms', 1 => 'Creator',],
            'search' => [0 => 'search', 1 => 'Search',],
            'archive' => [0 => 'archive', 1 => 'Archive',],
            'admin' => [0 => 'admin', 1 => 'Admin',],
            'terms-of-service' => [0 => 'legal/terms-of-service', 1 => 'Terms of service',],
            'privacy-policy' => [0 => 'legal/privacy-policy', 1 => 'Privacy policy',],
            'cookies' => [0 => 'legal/cookies', 1 => 'Cookies',],
            'sitemap' => [0 => 'sitemap.xml', 1 => 'Sitemap',],
            
            'back-to-top' => 'Back to Top',
            'eu-title' => 'EU Bureaucracy: Cookie banner',
            'banner-content' => 'This website, same as most other ones, uses cookies. Obviously, some stuff simply doesn\'t work without them. You can read more about them in our cookie policy. The banner only option will only set the required cookie for disabling this banner.',
            'banner-enable' => 'Enable cookies',
            'banner-only-banner' => 'Banner only',
            'banner-no' => 'Disallow cookies',
            'menu-unlock' => 'You\'ve just unlocked the menu!',
            'turn-off-animations' => 'Turn off animations',
            'turn-on-animations' => 'Turn on animations',
            'turn-off-banner-cookie' => 'Disable banner cookie',
            'enable-all-cookies' => 'Enable all cookies',
            'turn-off-cookies' => 'Disable cookies',
            'turn-on-bw' => 'Black & White mode',
            'turn-off-bw' => 'Colorful mode',
            'contact-me' => 'Contact me',
            'tutor' => [0 => 'tutor', 1 => 'Tutoring',],
            'close' => 'Close',
            
            'comment' =>
                [
                    'upvote' => 'Upvote',
                    'downvote' => 'Downvote',
                    'reply' => 'Reply',
                    'name' => 'Name',
                    'capcha' => 'What year is it?',
                    'comment-text' => 'Comment here. Your comment will be available once it is approved. Upvotes and downvotes will appear after the cache expires.',
                    'comment-button' => 'Comment',
                ],
            
            'generated-just-now' => 'Generated just now'
        ] : [
            'about' => [0 => 'o-nas', 1 => 'O mně',],
            'user' => [0 => 'uzivatel/login', 1 => 'Login',],
            'website' => [0 => 'o-nas/website', 1 => 'O webu',],
            'creator' => [0 => 'o-nas/martin-toms', 1 => 'O tvůrci',],
            'search' => [0 => 'search', 1 => 'Hledat',],
            'archive' => [0 => 'archiv', 1 => 'Archív',],
            'admin' => [0 => 'admin', 1 => 'Admin',],
            'terms-of-service' => [0 => 'legal/terms-of-service', 1 => 'Podmínky užívání',],
            'privacy-policy' => [0 => 'legal/privacy-policy', 1 => 'Osobní údaje',],
            'cookies' => [0 => 'legal/cookies', 1 => 'Cookies',],
            'sitemap' => [0 => 'sitemap.xml', 1 => 'Sitemap',],
            
            'back-to-top' => 'Zpět nahoru',
            'eu-title' => 'Byrokracie EU: Cookie banner',
            'banner-content' => 'Tento web, stejně jako většina ostatních, používá cookies. Je jasné že některé věci bez nich prostě nefungují. Můžete si o nich přečíst více v naší sekci cookie policy. Banner only nastaví cookie jen za účelem skrytí tohoto banneru.',
            'banner-enable' => 'Povolit cookies',
            'banner-only-banner' => 'Banner only',
            'banner-no' => 'Nepovolit cookies',
            'menu-unlock' => 'Odemkli jste menu!',
            'turn-off-animations' => 'Vypnout animace',
            'turn-on-animations' => 'Zapnout animace',
            'turn-off-banner-cookie' => 'Vypnout banner cookie',
            'enable-all-cookies' => 'Povolit všechny cookies',
            'turn-off-cookies' => 'Vypnout cookies',
            'turn-on-bw' => 'Černobílý režim',
            'turn-off-bw' => 'Barevný režim',
            'contact-me' => 'Kontaktujte mě',
            'tutor' => [0 => 'doucovani', 1 => 'Doučování',],
            'close' => 'Zavřít',
            
            'comment' => [
                'upvote' => 'Like',
                'downvote' => 'Dislike',
                'reply' => 'Odpovědět',
                'name' => 'Jméno',
                'capcha' => 'Co je za rok?',
                'comment-text' => 'Komentujte zde. Váš komentář se objeví až po jeho schválení. Upvoty a downvoty se objeví po vypršení cache.',
                'comment-button' => 'Comment',
                ],
    
            'generated-just-now' => 'Vygenerováno: Teď'
        ];
    }
    
    /**
     * Homepage related UI and other translations.
     *
     * @return array
     */
    public function homepage()
    {
        return ($this->english) ? [
            'article-metadata' => 'Article metadata',
            'newest' => 'Newest',
            'featured' => 'Featured',
            'recent' => 'Recent',
            'article' => 'article',
            'title' => 'Homepage',
            'description' => 'Personal website. Part Czech, part English - I publish some of my casual writing here. Most of my academic articles are available in Czech.'
        ] : [
            'article-metadata' => 'Metadata článku',
            'newest' => 'Nejnovější',
            'featured' => 'Vybrané',
            'recent' => 'Poslední',
            'article' => 'clanek',
            'title' => 'Domovská stránka',
            'description' => 'Osobní web. Píšu zde občas články, které se mohou hodit studentům a časem i něco víc.'
        ];
    }
    
    /**
     * About page related UI and other translations.
     *
     * @return array
     */
    public function about()
    {
        return ($this->english) ? [
            'about-me' => 'I\'m a full-time student in the Faculty of Economics and Management of Czech University of Life Sciences Prague. I enjoy pretty much anything that requires some manner of creativity or thinking, totally love acquiring new skills - the weirder the better. I get bored easily.',
            'rule' => 'General rule - be yourself - no matter what that means, don\'t try to be something you\'re not and we\'ll get along just fine. We all have our differences - that\'s what makes us the same.',
            'communication' => 'That being said, I hate lying, don\'t like being ignored nor any forms of discrimination (targeted at me or anyone else.)',
            'skills' =>
                [
                    'title' => 'Programming & related',
                    'sql' =>
                        [
                            'name' => 'MariaDb, SQL',
                            'level' => 'expert',
                        ],
                    'html' =>
                        [
                            'name' => 'HTML, Latte',
                            'level' => 'expert',
                        ],
                    'php' =>
                        [
                            'name' => 'PHP, OOP, MVC',
                            'level' => 'expert',
                        ],
                    'css' =>
                        [
                            'name' => 'SASS, CSS3, BEM',
                            'level' => 'better',
                        ],
                    'js' =>
                        [
                            'name' => 'JavaScript, jQuery',
                            'level' => 'advanced',
                        ],
                    'c' =>
                        [
                            'name' => 'C#',
                            'level' => 'basic',
                        ],
                ],
            'languages' =>
                [
                    'title' => 'Communication',
                    'czech' => 'Native-Czech',
                    'english' => 'C2-English',
                    'italian' => 'A1-Italian',
                ],
        ] : [
            'about-me' => 'Jsem studentem prezenčního studia Provozně ekonomické fakulty ČZU v Praze. Mám rád v podstatě cokoliv, pokud je k tomu potřeba alespoň trocha kreativity nebo myšlení. Hodně rád nabírám nové dovednosti a znalosti - čím divnější, tím lepší. Snadno se znudím.',
            'rule' => 'Obecné pravidlo - buď sám sebou - ať to znamená cokoliv, nesnaž se být něčím, čím nejsi, a vyjdeme spolu. Jsou mezi námi všemi rozdíly - a to nás činí stejnými.',
            'communication' => 'Ale i tak, nenávidím lhaní a nemám rád když mě někdo ignoruje nebo jakékoliv formy diskriminace (ať už cílené na mě nebo na někoho jiného.)',
            'skills' =>
                [
                    'title' => 'Programování apod.',
                    'sql' =>
                        [
                            'name' => 'MariaDb, SQL',
                            'level' => 'expert',
                        ],
                    'html' =>
                        [
                            'name' => 'HTML, Latte',
                            'level' => 'expert',
                        ],
                    'php' =>
                        [
                            'name' => 'PHP, OOP, MVC',
                            'level' => 'expert',
                        ],
                    'css' =>
                        [
                            'name' => 'SASS, CSS3, BEM',
                            'level' => 'better',
                        ],
                    'js' =>
                        [
                            'name' => 'JavaScript, jQuery',
                            'level' => 'advanced',
                        ],
                    'c' =>
                        [
                            'name' => 'C#',
                            'level' => 'basic',
                        ],
                ],
            'languages' =>
                [
                    'title' => 'Komunikace',
                    'czech' => 'Čeština - mateřština',
                    'english' => 'Angličtina C2',
                    'italian' => 'Italština A1',
                ],
        ];
    }
    
    /**
     * Article related UI and other translations.
     *
     * @return array
     */
    public function article()
    {
        return ($this->english) ?
            [
                'next' => 'Next',
                'previous' => 'Previous',
                'next-or-previous' => 'Articles within the same series',
                'social-media-title' => 'Social media sharing',
                'comments' => 'Comments',
                'article' => 'article',
                'articles' => 'Articles',
                'archive' => 'archive',
                'topics' => 'Topics',
                'modified' => 'Modified',
                'by' => 'By',
                'word-estimate' => 'Words',
                'minute-read' => 'Minute Read',
                'written' => 'Written',
                'comment' =>
                    [
                        'upvote' => 'Upvote',
                        'downvote' => 'Downvote',
                        'reply' => 'Reply',
                        'name' => 'Name',
                        'capcha' => 'What year is it?',
                        'comment-text' => 'Comment here. Your comment will be visible once it is approved.',
                        'comment-button' => 'Comment',
                    ],
            ] : [
                'next' => 'Další',
                'previous' => 'Předchozí',
                'next-or-previous' => 'Články ve stejné sérii',
                'social-media-title' => 'Linky na sdílení',
                'comments' => 'Komentáře',
                'article' => 'clanek',
                'articles' => 'Články',
                'archive' => 'archiv',
                'topics' => 'Rubriky',
                'modified' => 'Upraveno',
                'by' => 'Napsal',
                'word-estimate' => 'slov',
                'minute-read' => 'minutová četba',
                'written' => 'Přidáno',
                'comment' =>
                    [
                        'upvote' => 'Like',
                        'downvote' => 'Dislike',
                        'reply' => 'Odpovědět',
                        'name' => 'Jméno',
                        'capcha' => 'Co je za rok?',
                        'comment-text' => 'Komentujte zde. Váš komentář se zobrazí až bude schválen',
                        'comment-button' => 'Komentovat',
                    ],
            ];
    }
    
    /**
     * The default description for the meta tag.
     *
     * @return string
     */
    public function defaultDescription()
    {
        return ($this->english) ? 'Personal website. Part Czech, part English - I publish some of my casual writing here. Most of my academic articles are available in Czech.' : 'Osobní web. Píšu zde občas články, které se mohou hodit studentům a časem i něco víc.';
    }
}