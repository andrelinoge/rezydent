<?php
/**
 * @author Andriy Tolstokorov
 */

class AccountSideBar extends CWidget
{
    public function run()
    {
        $this->render(
            'account-side-bar',
            array(
                'model' => Yii::app()->user->getModel(),
                'avatarUploadHandlerUrl' => createUrl( 'TouristDating/uploadAvatarHandler' ),
                'loginForm' => new LoginForm(),
                'registrationForm' => new RegistrationForm(),
                'restorePasswordForm' => new RestorePasswordForm(),
                'restorePasswordHandlerUrl' => createUrl( 'TouristDating/restorePasswordHandler' ),
                'registrationHandlerUrl' => createUrl( 'TouristDating/registrationHandler' ),
                'loginHandlerUrl' => createUrl( 'TouristDating/loginHandler' ),
            )
        );
    }
}