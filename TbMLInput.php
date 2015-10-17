<?php

Yii::import('bootstrap.widgets.input.TbInput');
Yii::import('bootstrap.widgets.TbTabs');

/**
* MultiLingual Input
*/
class TbMLInput extends CWidget
{
	public $type = TbInput::TYPE_TEXT;
	public $form;
	public $model;
	public $attribute;
	public $block = false;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$tabs = array();

		foreach (param('translatedLanguages') as $l => $lang) {
			if (app()->sourceLanguage === $l) {
				$suffix = '';
			} else {
				$suffix = '_'.$l;
			}

			switch ($this->type) {
				case TbInput::TYPE_TEXT:
						$content = $this->form->textFieldRow(
							$this->model,
							($this->attribute.$suffix),
							array(
								'style'=>'margin-bottom:1px;',
								'class'=>($this->block)?'input-block-level':''
							)
						);
					break;
				case TbInput::TYPE_REDACTOR:
						$content = $this->form->redactorRow(
							$this->model,
							($this->attribute.$suffix),
							array (
								'editorOptions' => array(
									'buttons' => array('html','bold','italic','|','unorderedlist','orderedlist','outdent','indent','|','image','video','|','link','alignment','horizontalrule','formatting','table'),
									'imageGetJson' => url('/admin/media/json'),
									'predefinedLinks' => url('/admin/page/json'),
									'minHeight' => '300',
									'removeEmptyTags' => false,
									'convertDivs' => false,
									// 'tidyHtml' => false,
									'removeEmptyTags' => false,
									// 'cleanup' => false,
									'iframe' => true,
									'linebreaks' => true,
									'css' => array(bu('css/style.css'),bu('css/red_fix.css')),
									'formattingTags'=>array('h1','h2','h3','h4','p','span')
								),
							)
						);
					break;

				default:
						throw new CException(__CLASS__ . ': Failed to run widget! Type is invalid.');
					break;
			}

			$tabs[] = array(
				'label'=>$l,
				'content'=>$content,
				'active'=>(app()->sourceLanguage === $l),
				'linkOptions'=>array('style'=>'padding:3px 6px;font-size:12px;line-height:12px;'),
			);
		}

		$this->controller->widget(
			'bootstrap.widgets.TbTabs',
			array(
				'tabs'=>$tabs,
				'type'=>'pills',
				'placement' => 'below',
			)
		);
	}
}

?>