<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\user\User;
use app\models\user\UserSearch;
use app\models\user\Login;
use app\models\user\ForgotPassword;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','forgot-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new User();
        if ($model->load(Yii::$app->getRequest()->post())) {
          $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
          if ($user = $model->signup()) {
            Yii::$app->session->setFlash('success', 'Signup User Success');
            return $this->redirect(['index']);
          }else{
            Yii::$app->session->setFlash('danger', 'Singup Failed');
          }
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_EDIT;
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->edit()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->edit()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteByStatus();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = User::find()->where(['id'=>$id])->andWhere(['!=','status',User::DELETED])->one();
        if ($model != null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateStatus($id){
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->status = Yii::$app->request->post('status',0);
            $model->save(false);
        }
        return true;
    }

    public function actionSendforgotlink(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $model = new ForgotPassword();
            $model->email = $data['email'];
            if($model->sendEmailForgot()){
                $message = 'Forgot password link sent';
            }else
                $message = 'Failed to send link, please try again!';

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'message' => $message,
            ];
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $accessChecker = Yii::$app->accessChecker;
            $userVendor = Yii::$app->user->identity->userVendor;
            if( $accessChecker->getIsVendorAdmin() || $accessChecker->getIsVendorSubAdmin() ){

                if(isset($userVendor->vendor)){
                    if($userVendor->password_changed == $userVendor::PASSWORD_CHANGED_NO){
                        return $this->redirect($userVendor->getChangePassword());
                    }else if($accessChecker->getIsVendorAdmin() 
                    && $userVendor->vendor->data_status == Vendor::DATA_STATUS_NEW){
                        return $this->redirect($userVendor->vendor->getProfileUrl());
                    }
                }else{
                    Yii::$app->session->setFlash('danger', 'Your Account Not Assosiated with any vendor, please contact admin');
                    Yii::$app->user->logout(false);
                    return $this->redirect(['/site/login']);
                }
                
            }
            
            return $this->goBack();
        }

        $model->password = '';
        // $this->layout = 'main-login';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Forgot Password action.
     *
     * @return Response|string
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPassword();
        if ($model->load(Yii::$app->request->post())) {     
            if($model->sendEmailForgot()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check you email'));       
                return $this->goBack();
            }else{
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Your email not registered'));
            }
            
        }
        // $this->layout = 'main-login';
        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    /**
     * New Password action.
     *
     * @return Response|string
     */
    public function actionResetPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ResetPassword();
        $tokenStatus = $model->checkToken(Yii::$app->request->get('akey'));
        if($tokenStatus['status']){
            if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Login with your new password'));
                return $this->redirect('site/login');
            }
            // $this->layout = 'main-login';
            return $this->render('reset-password', [
                'model' => $model,
            ]);
        }

        // $this->layout = 'main-login';
        return $this->render('error-exception',[
            'message' => isset($tokenStatus['message']) ? $tokenStatus['message'] : Yii::t('app', 'Page not Found')
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // public function actionAssignRole($id){
    //   $model = $this->findModel($id);
    //   if (Yii::$app->request->isPost) {
    //       if ($model->saveAssingRole(Yii::$app->request->post())) {
    //         Yii::$app->session->setFlash('success', 'Access Granted');
    //         return $this->redirect(['index']);
    //       }
    //   }
    //   return $this->render('assign-role',[
    //     'model' => $model
    //   ]);
    // }
}
