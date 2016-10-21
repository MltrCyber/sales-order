<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass . "\n"; ?>
{

public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations
);
}

public function accessRules()
{
return array(
array('allow',  // allow all users to perform 'index' and 'view' actions
'actions'=>array('index','view'),
'users'=>array('*'),
),
array('allow', // allow authenticated user to perform 'create' and 'update' actions
'actions'=>array('create','update'),
'users'=>array('@'),
),
array('allow', // allow admin user to perform 'admin' and 'delete' actions
'actions'=>array('admin','delete'),
'users'=>array('admin'),
),
array('deny',  // deny all users
'users'=>array('*'),
),
);
}

public function actionView($id)
{
$this->render('view',array(
'model'=>$this->loadModel($id),
));
}

public function actionCreate()
{
$model=new <?php echo $this->modelClass; ?>;

if(isset($_POST['<?php echo $this->modelClass; ?>']))
{
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
if($model->save())
$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
}

$this->render('create',array(
'model'=>$model,
));
}

public function actionUpdate($id)
{
$model=$this->loadModel($id);

if(isset($_POST['<?php echo $this->modelClass; ?>']))
{
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
if($model->save())
$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
}

$this->render('update',array(
'model'=>$model,
));
}

public function actionDelete($id)
{
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

public function actionIndex()
{
$model=new <?php echo $this->modelClass; ?>('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['<?php echo $this->modelClass; ?>']))
$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

$this->render('admin',array(
'model'=>$model,
));
}

public function loadModel($id)
{
$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
