<?php if (!empty(validation_errors())): ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php $this->load->view('templates/alert', ['type' => 'danger', 'caption' => 'Error', 'text' => validation_errors()]) ?>
    </div>
</div>
<?php endif ?>

<?php if (isset($email_sent)): ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php if ($email_sent === true): ?>
        <div class="alert alert-success">
            <p>Your message has been successfuly sent!</p>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            <p>An error has occurred while sending the message :(</p>
        </div>
        <?php endif ?>
    </div>
</div>
<?php endif ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= form_open() ?>
            <legend>Contact us</legend>

            <div class="well">
                <div class="form-group required">
                    <?php $field = $form['name'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['email'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['subject'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_input(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group required">
                    <?php $field = $form['message'] ?>
                    <?= form_label($field['label'], $field['name']) ?>
                    <?= form_textarea(['name' => $field['name'], 'id' => $field['name'], 'value' => $this->input->post($field['name']), 'class' => 'form-control']) ?>
                </div>
            </div>

            <div class="form-group"><button class="btn btn-default" type="submit">Submit</button></div>
        <?= form_close() ?>
    </div>
</div>
