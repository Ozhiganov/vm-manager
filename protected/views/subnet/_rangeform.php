<?php
/*
 * Copyright (C) 2012 FOSS-Group
 *                    Germany
 *                    http://www.foss-group.de
 *                    support@foss-group.de
 *
 * Authors:
 *  Christian Wittkowski <wittkowski@devroom.de>
 *
 * Licensed under the EUPL, Version 1.1 or – as soon they
 * will be approved by the European Commission - subsequent
 * versions of the EUPL (the "Licence");
 * You may not use this work except in compliance with the
 * Licence.
 * You may obtain a copy of the Licence at:
 *
 * http://www.osor.eu/eupl
 *
 * Unless required by applicable law or agreed to in
 * writing, software distributed under the Licence is
 * distributed on an "AS IS" basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied.
 * See the Licence for the specific language governing
 * permissions and limitations under the Licence.
 *
 *
 */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'range-form',
	'enableAjaxValidation'=>true,
	'method' => 'post',
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	)
));
	echo $form->hiddenField($model, 'subnetDn');
	echo $form->hiddenField($model, 'subnet');
	echo $form->hiddenField($model, 'dn');
	$attributeLabels = $model->attributeLabels();
?>
		<div class="row">
			<?php echo $form->label($model,'subnet'); ?>
			<?php echo CHtml::label($subnet, false, array('style' => 'font-weight: normal')); ?>
		</div>
		<br/>
		<div class="column">
			<div class="row">
				<?php echo $form->labelEx($model, 'ip'); ?>
				<?php echo $form->textField($model,'ip',array('size'=>20, 'style'=>"float: left;")); ?>
				<br/><br/>
				<?php echo $form->error($model,'ip'); ?>
			</div>
		</div>
		<div class="column span-5">
			<div class="row">
				<?php echo $form->labelEx($model, 'netmask'); ?>
				<?php echo $form->dropDownList($model,'netmask', $netmasks, array('prompt'=>'', 'style'=>"float: left; margin-right: 4px;")); ?>
				<br/><br/>
				<?php echo $form->error($model,'netmask'); ?>
			</div>
		</div>
		<br class="clear"/>
		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>20)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<br/>
		<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type', $types); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($submittext, array('id' => 'submit')); ?>
		</div>
	</div>
	<br class="clear"/>
<?php $this->endWidget(); ?>

</div><!-- form -->