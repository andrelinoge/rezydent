<?php
/**
 * @author Andre Linoge
 */

class GetText extends CApplicationComponent
{
    /**
     * @var GetText domain.
     */
    public $domain = NULL;

    /**
     * @var Directory containing gettext messages.
     */
    public $localeDir = '/messages/get-text';

    /**
     * Initialize php's gettext.
     */
    public function init()
    {
        // check if necessary params are seted
        if ( !$this->domain ) {
            throw new CException( 'Set domain for GetText extension' );
        }

        $localeDir = Yii::app()->getBasePath() . $this->localeDir;
        if ( !is_dir( $localeDir ) ) {
            throw new CException( 'Wrong path for locale folder or folder doesn`t exists. Default folder is $bathPath + /messages/get-text' );
        }

        // get current lang from cookie or from config
        if(isset(Yii::app()->request->cookies['language'])) {
            $locale = Yii::app()->request->cookies['language']->value;

            // if locale in short form (ua, ru, en ...) - replace it with full form
            if ( strlen( $locale ) == 2 ) {
                $params = Yii::app()->params;
                $isLocaleParams = isset( $params->availableLocalesInShortForm ) &&
                    isset( $params->availableLocalesInFullForm );

                if ( $isLocaleParams ) { // is necessary params in config files
                    if ( in_array( $locale, $params->availableLocalesInShortForm ) ) {
                        $locale = $params->availableLocalesInFullForm[ $locale ];
                    } else {
                        $locale = Yii::app()->getLanguage(); // use current locale in current form
                    }
                } else {
                    $locale = Yii::app()->getLanguage(); // use current locale in current form
                }
            } else {
                $locale = Yii::app()->getLanguage(); // use current locale in current form
            }
        } else { // use current locale in current form
            $locale = Yii::app()->getLanguage();
        }

        $locale = $this->getLocaleID( $locale );
        header( 'Content-Language: ' . str_replace( '_', '-', $locale ) );

        // Set enviroment
        putenv( 'LC_ALL=' . $locale );
        putenv( 'LANG=' . $locale );
        putenv( 'LANGUAGE=' . $locale );

        // Set locale
        if ( !setlocale (LC_ALL, $locale . '.utf8', $locale . '.utf-8', $locale . '.UTF8', $locale . '.UTF-8' ) ) {
            // Set current locale
            setlocale(LC_ALL, '');
        }

        bind_textdomain_codeset( $this->domain, 'utf-8' );
        bindtextdomain( $this->domain, $localeDir );
        textdomain( $this->domain );

    }


    /**
     * Convert yii's canonical locale to the format required for gettext, for example ru_ru -> ru_RU
     * ( reverse of CLocale::getCanonicalID() )
     */
    protected function getLocaleID( $canonicalLocale )
    {
        $locale = explode( '_', $canonicalLocale );
        if ( isset( $locale[1] ) ) {
            $locale[1] = strtoupper( $locale[1] );
        }
        return implode('_', $locale);
    }

}