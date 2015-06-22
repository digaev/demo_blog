<?php if (!empty(validation_errors())): ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php $this->load->view('templates/alert', ['type' => 'danger', 'caption' => 'Error', 'text' => validation_errors()]) ?>
    </div>
</div>
<?php endif ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= form_open() ?>
            <legend><?= $title ?></legend>

            <div class="well">
                <div class="form-group required">
                    <?php $field = $form['username'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['email'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['password'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['type' => 'password', 'name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['password_confirmation'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['type' => 'password', 'name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>

                <div class="checkbox">
                    <?php $field = $form['terms'] ?>
                    <label for="<?= $field['name'] ?>">
                        <?= form_checkbox(['name' => $field['name'], 'id' => $field['name'], 'value' => 1, 'checked' => !empty($this->input->post($field['name']))]) ?>
                        <span><?= $form['terms']['label'] ?></span>
                    </label>
                </div>
            </div>

            <div class="form-group"><button class="btn btn-default" type="submit">Submit</button></div>
        <?= form_close() ?>
    </div>
</div>
