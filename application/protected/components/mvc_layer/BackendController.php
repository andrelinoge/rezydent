<?php
/**
 * @author Andriy Tolstokorov
 */

class BackendController extends Controller
{

    public function init()
    {
        $this->pageTitle=Yii::app()->name . '-' . 'Dashboard';
        $this->setLayout( 'backend' );
        parent::init();
    }

    public function getMenu()
    {
        $currentAction = strtolower( $this->action->id );

        $menuItems = array(
            array(
                'title' => _( 'Контактні повідомлення' ),
                'url' => $this->createUrl('ContactMessages/all'),
                'activityMarker' => 'ContactMessages',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Всі повідомлення' ),
                        'url' => $this->createUrl( 'ContactMessages/all' ),
                        'activityMarker' => 'all'
                    ),
                    array(
                        'title' => _( 'Непрочитані повідомлення' ),
                        'url' => $this->createUrl( 'ContactMessages/unread' ),
                        'activityMarker' => 'unread'
                    )
                )
            ),

            array(
                'title' => _( 'Запити на консультацію' ),
                'url' => $this->createUrl('ConsultationMessages/all'),
                'activityMarker' => 'ConsultationMessages',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Всі запити на консультацію' ),
                        'url' => $this->createUrl( 'ConsultationMessages/all' ),
                        'activityMarker' => 'all'
                    ),
                    array(
                        'title' => _( 'Непрочитані' ),
                        'url' => $this->createUrl( 'ConsultationMessages/unread' ),
                        'activityMarker' => 'unread'
                    )
                )
            ),

            array(
                'title' => _( 'Статичні сторінки' ),
                'activityMarker' => 'StaticPage',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Головна' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::HOME ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Контакти' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::CONTACT ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Часті запитання' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::FAQ ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Новини' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::NEWS ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Пошук турів' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURS ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Акційні пропозиці' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::HOT_PROPOSITION ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Візи і консульства' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::EMBASSIES ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Пошук квитків' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TICKETS ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Пошук квитків - авіаквитки' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TICKETS_AIR ) ),
                        'activityMarker' => 'edit'
                    ),
                    array(
                        'title' => _( 'Пошук квитків - квитки на поїзд' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TICKETS_TRAIN ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Тури - відпочинок за кордоном' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURS_ABROAD ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Тури - лікувальні тури' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURS_HEALTH ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Тури - тури для дітей' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURS_CHILDREN ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Тури - відпочинок в Україні' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURS_UKRAINE ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Пасажирські перевезення' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::PASSENGER ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Погода' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::WEATHER ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Погода - курорти' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::WEATHER_RESORT ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Погода - моря' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::WEATHER_SEA ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Фото та відео' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::MEDIA ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Працевлаштування за кордоном' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::WORK ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Туристичні знайомства' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::TOURIST_DATING ) ),
                        'activityMarker' => 'edit'
                    ),

                    array(
                        'title' => _( 'Туристичні знайомства - заблокований аккаунт' ),
                        'url' => $this->createUrl( 'StaticPage/edit', array( 'id' => StaticPages::ACCOUNT_BANNED ) ),
                        'activityMarker' => 'edit'
                    ),
                )
            ),

            array(
                'title' => _( 'Запитання' ),
                'url' => $this->createUrl('Faq/index'),
                'activityMarker' => 'Faq',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'Faq/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'Faq/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Новини' ),
                'url' => $this->createUrl('News/index'),
                'activityMarker' => 'News',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'News/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'News/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Фото та відео' ),
                'url' => $this->createUrl('Media/index'),
                'activityMarker' => 'Media',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'Media/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'Media/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Візи та консульства' ),
                'url' => $this->createUrl('Embassies/index'),
                'activityMarker' => 'Embassies',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'Embassies/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'Embassies/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Акційні                                                                                                               пропозиції' ),
                'url' => $this->createUrl('Proposition/index'),
                'activityMarker' => 'Proposition',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'Proposition/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'Proposition/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Тури для дітей' ),
                'url' => $this->createUrl('ToursChildren/index'),
                'activityMarker' => 'ToursChildren',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Країни' ),
                        'url' => $this->createUrl( 'ToursChildren/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати країну' ),
                        'url' => $this->createUrl( 'ToursChildren/add' ),
                        'activityMarker' => 'add'
                    ),

                    array(
                        'title' => _( 'Тури' ),
                        'url' => $this->createUrl( 'ToursChildren/articles' ),
                        'activityMarker' => 'articles'
                    ),

                    array(
                        'title' => _( 'Додати тур' ),
                        'url' => $this->createUrl( 'ToursChildren/addArticle' ),
                        'activityMarker' => 'addArticle'
                    )
                )
            ),

            array(
                'title' => _( 'Лікувальні тури' ),
                'url' => $this->createUrl('ToursHealth/index'),
                'activityMarker' => 'ToursHealth',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Категорії' ),
                        'url' => $this->createUrl( 'ToursHealth/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати категорію' ),
                        'url' => $this->createUrl( 'ToursHealth/add' ),
                        'activityMarker' => 'add'
                    ),

                    array(
                        'title' => _( 'Тури' ),
                        'url' => $this->createUrl( 'ToursHealth/articles' ),
                        'activityMarker' => 'articles'
                    ),

                    array(
                        'title' => _( 'Додати тур' ),
                        'url' => $this->createUrl( 'ToursHealth/addArticle' ),
                        'activityMarker' => 'addArticle'
                    )
                )
            ),

            array(
                'title' => _( 'Відпочинок в Україні' ),
                'url' => $this->createUrl('ToursUkraine/index'),
                'activityMarker' => 'ToursUkraine',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Категорії' ),
                        'url' => $this->createUrl( 'ToursUkraine/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати категорію' ),
                        'url' => $this->createUrl( 'ToursUkraine/add' ),
                        'activityMarker' => 'add'
                    ),

                    array(
                        'title' => _( 'Тури' ),
                        'url' => $this->createUrl( 'ToursUkraine/articles' ),
                        'activityMarker' => 'articles'
                    ),

                    array(
                        'title' => _( 'Додати тур' ),
                        'url' => $this->createUrl( 'ToursUkraine/addArticle' ),
                        'activityMarker' => 'addArticle'
                    )
                )
            ),

            array(
                'title' => _( 'Екскурсійні тури за кордон' ),
                'url' => $this->createUrl('ToursAbroad/index'),
                'activityMarker' => 'ToursAbroad',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Список статтей' ),
                        'url' => $this->createUrl( 'ToursAbroad/index' ),
                        'activityMarker' => 'index'
                    ),
                    array(
                        'title' => _( 'Додати нову' ),
                        'url' => $this->createUrl( 'ToursAbroad/add' ),
                        'activityMarker' => 'add'
                    )
                )
            ),

            array(
                'title' => _( 'Націнка до валют' ),
                'url' => $this->createUrl('CurrencyModifier/index'),
                'activityMarker' => 'CurrencyModifier',
                'active' => $currentAction,
            ),

            array(
                'title' => _( 'Підписники' ),
                'url' => $this->createUrl('Subscribers/index'),
                'activityMarker' => 'Subscribers',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Списоки підписників' ),
                        'url' => $this->createUrl( 'Subscribers/index' ),
                        'activityMarker' => 'all'
                    ),
                    array(
                        'title' => _( 'Розсилка' ),
                        'url' => $this->createUrl( 'Subscribers/MassDelivery' ),
                        'activityMarker' => 'MassDelivery'
                    ),
                    array(
                        'title' => _( 'Емейли для ручної розсилки' ),
                        'url' => $this->createUrl( 'Subscribers/ManualDelivery' ),
                        'activityMarker' => 'ManualDelivery'
                    )
                )
            ),

            array(
                'title' => _( 'Туристичні знайомства' ),
                'activityMarker' => 'TouristDating',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Сімейні статуси' ),
                        'url' => $this->createUrl( 'TouristDating/maritalStatus' ),
                        'activityMarker' => 'maritalStatus'
                    ),
                    array(
                        'title' => _( 'Поїздка для' ),
                        'url' => $this->createUrl( 'TouristDating/tripPurpose' ),
                        'activityMarker' => 'tripPurpose'
                    ),
                    array(
                        'title' => _( 'З ким їхати' ),
                        'url' => $this->createUrl( 'TouristDating/tripWith' ),
                        'activityMarker' => 'tripWith'
                    ),
                    array(
                        'title' => _( 'Кого шукають в поїздку' ),
                        'url' => $this->createUrl( 'TouristDating/tripCompanion' ),
                        'activityMarker' => 'tripCompanion'
                    ),
                    array(
                        'title' => _( 'Їду в' ),
                        'url' => $this->createUrl( 'TouristDating/country' ),
                        'activityMarker' => 'country'
                    ),
                    array(
                        'title' => _( 'Користувачі' ),
                        'url' => $this->createUrl( 'Users/users' ),
                        'activityMarker' => 'Users'
                    ),
                )
            ),

            array(
                'title' => _( 'Слайдер' ),
                'url' => $this->createUrl('Slider/index'),
                'activityMarker' => 'Slider',
                'active' => $currentAction,
            ),

            array(
                'title' => _( 'Адміністрація сайту' ),
                'url' => $this->createUrl('Users/admins'),
                'activityMarker' => 'Users',
                'active' => $currentAction,
                'items' => array(
                    array(
                        'title' => _( 'Списоки адміністраторів' ),
                        'url' => $this->createUrl( 'Users/admins' ),
                        'activityMarker' => 'admins'
                    ),
                    array(
                        'title' => _( 'Змінити поточний пароль' ),
                        'url' => $this->createUrl( 'Users/ChangeCurrentPassword' ),
                        'activityMarker' => 'ChangeCurrentPassword'
                    )
                )
            ),
        );


        return $menuItems;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel( $modelName )
    {
        if( $this->_model === NULL )
        {
            $id = getParam( 'id' );

            if( $id ) {
                $this->_model = $modelName::model()->findbyPk( $id );
            } else {
                if ( isset( $_POST[ $modelName ] ) ) {
                    if ( isset( $_POST[ $modelName ][ 'id' ] ) ) {
                        $id = $_POST[ $modelName ][ 'id' ];
                        if ( $id ) {
                            $this->_model = $modelName::model()->findbyPk( $id );
                        }
                    }
                }
            }

            if($this->_model === NULL) {
                throw new CHttpException(404,'The requested page does not exist.');
            }
        }
        return $this->_model;
    }




}