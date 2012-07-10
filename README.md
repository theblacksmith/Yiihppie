# Yiihppie!

Welcome to Yii HamlPHP Parser Integration Extension

## It's simple...

Yiihppie is an [Yii](http://www.yiiframework.com) extension that let's you use [Haml](http://haml.info) in your views by integrating the amazing [HamlPHP](http://github.com/hamlphp/HamlPHP) parser.

## How to install

1. [Download](https://github.com/theblacksmith/Yiihppie/zipball/master) the extension
2. Extract it to your-app/protected/extensions/yiihppie
3. Add this to your `config/main.php` file

		'components'=>array(
			...
			'viewRenderer'=>array(
				'class'=>'ext.yiihppie.Haml',
				'fileExtension'=>'.haml'
			),
			...
		)
4. You are done! Go write some haml views! :) <br/>
	(You'll have to save them with .haml extension)

**Want fancy editor support?** I use [Aptana Studio 3](http://www.aptana.com/products/studio3/download)