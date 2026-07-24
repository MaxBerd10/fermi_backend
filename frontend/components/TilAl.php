<?

namespace frontend\components;
class TilAl extends \yii\base\Behavior
{
	public function events()
	{
		return [\yii\web\Application::EVENT_BEFORE_REQUEST=>'chan'];
	}
	public function chan()
	{
		if(\Yii::$app->session->has("til"))
		{
			\Yii::$app->language=\Yii::$app->session->get("til");
		}
	}
}

?>