<div class="page-header">
    <h2><?= t('External DB Auth settings') ?></h2>
</div>

<!-- TODO : Traduire tous les t() -->
<!-- TODO : Permettre d'enregistrer field par field ! Ou tous les fields d'un coup ?? -->
<!-- TODO : Selon type DB sélectionné, afficher ou cacher les champs nécessaires :) -->
<!-- TODO : Ajouter support sqlite et mssql -->
<!-- TODO : Ajouter support mysql cert (ou pas lol) -->

<!-- Champs :
Global :
  *ExternalDbAuth_type : mysql/postgres TODO : Possible de supporter sqlite et mssql, mais oskour
  *ExternalDbAuth_host : string
  *ExternalDbAuth_db : string
  ExternalDbAuth_prefix("") string : Préfixe à appliquer à toutes les tables
  *ExternalDbAuth_user string
  *ExternalDbAuth_pwd string
  ExternalDbAuth_port(3306) int

User :
  *ExternalDbAuth_user_table string
  *ExternalDbAuth_user_id string
  *ExternalDbAuth_user_username string
  *ExternalDbAuth_user_pwd string
  *ExternalDbAuth_user_pwd_encryption : none/PHP
  ExternalDbAuth_user_nickname(same as ExternalDbAuth_user_username) string
  ExternalDbAuth_user_email("") string
  ExternalDbAuth_user_active(all enabled) string
  ExternalDbAuth_user_active_logic(active => 1 enabled) block/active

Groups :
  *ExternalDbAuth_group_table string
  *ExternalDbAuth_group_id string
  *ExternalDbAuth_group_name string

Mappping :
  *ExternalDbAuth_mapping_table string
  *ExternalDbAuth_mapping_user string
  ExternalDbAuth_mapping_user_type (id) : id/name
  *ExternalDbAuth_mapping_group string
  ExternalDbAuth_mapping_group_type (id) : id/name
-->

<?= $this->asset->js('plugins/ExternalDbAuth/assets/js/config.js') ?>

<input type="hidden" value="<?= $this->url->base().'plugins/ExternalDbAuth/assets/php/check_connection.php' ?>" id="URL_test_connection" />
<span style="display:none;" id="msg-connection-success"><?= t('Successfully connected to the external DB !') ?></span>
<span style="display:none;" id="msg-connection-fail"><?= t('An error happend while trying to connect to the external DB, please see JS console for more details.') ?></span>

<form method="post" action="<?= $this->url->href('ConfigController', 'save', array('plugin' => 'ExternalDbAuth')) ?>" autocomplete="off">

    <?= $this->form->csrf() ?>

    <fieldset>
      <legend><?= t('External DB Informations') ?></legend>

      <!-- DB Type -->
      <?= $this->form->label(t('DB Type'), "ExternalDbAuth_type") ?>
      <?= $this->form->select("ExternalDbAuth_type",
        [
          "mysql" => "mysql",
          "postgres" => "postgres",
        ],
        $values
      ) ?>

      <!-- Hôte -->
      <?= $this->form->label(t('Host'), "ExternalDbAuth_host") ?>
      <?= $this->form->text("ExternalDbAuth_host", $values, array(), ["required"]) ?>

      <!-- DB -->
      <?= $this->form->label(t('Database'), "ExternalDbAuth_db") ?>
      <?= $this->form->text("ExternalDbAuth_db", $values, array(), ["required"]) ?>

      <!-- DB -->
      <?= $this->form->label(t('Tables prefix'), "ExternalDbAuth_prefix") ?>
      <?= $this->form->text("ExternalDbAuth_prefix", $values, array()) ?>

      <!-- User -->
      <?= $this->form->label(t('User'), "ExternalDbAuth_user") ?>
      <?= $this->form->text("ExternalDbAuth_user", $values, array(), ["required"]) ?>

      <!-- pwd -->
      <?= $this->form->label(t('Password'), "ExternalDbAuth_pwd") ?>
      <?= $this->form->password("ExternalDbAuth_pwd", $values, array(), ["required"]) ?>

      <!-- port -->
      <?= $this->form->label(t('Port'), "ExternalDbAuth_port") ?>
      <?php if(!isset($values["ExternalDbAuth_port"])) $values["ExternalDbAuth_port"] = 3306; ?>
      <?= $this->form->number("ExternalDbAuth_port", $values, array(), ["required"]) ?>

      <!-- Test connection -->
      <?= $this->form->label(t('Test connection'), "") ?>
      <button id="b-test_connection" type="button"><?= t('Test connection') ?></button>
      <div id="connection_result"></div>
    </fieldset>

    <fieldset>
      <legend><?= t('User table') ?></legend>
      <!-- table -->
      <?= $this->form->label(t('Table name for users'), "ExternalDbAuth_user_table") ?>
      <?= $this->form->text("ExternalDbAuth_user_table", $values, array(), ["required"]) ?>

      <!-- ID -->
      <?= $this->form->label(t('"ID" field name'), "ExternalDbAuth_user_id") ?>
      <?= $this->form->text("ExternalDbAuth_user_id", $values, array(), ["required"]) ?>

      <!-- Username -->
      <?= $this->form->label(t('"Username" field name'), "ExternalDbAuth_user_username") ?>
      <?= $this->form->text("ExternalDbAuth_user_username", $values, array(), ["required"]) ?>

      <!-- password -->
      <?= $this->form->label(t('"Password" field name'), "ExternalDbAuth_user_pwd") ?>
      <?= $this->form->text("ExternalDbAuth_user_pwd", $values, array(), ["required"]) ?>

      <!-- password method -->
      <?= $this->form->label(t('"Password" encryption'), "ExternalDbAuth_user_pwd_encryption") ?>
      <?= $this->form->select(
        "ExternalDbAuth_user_pwd_encryption",
        [
          "none" => t('No encryption (plain)'),
          "PHP" => t("PHP password_verify"),
          // TODO : Remplir d'autres méthodes... #help
        ],
        $values
      ) ?>

      <!-- Nickname -->
      <?= $this->form->label(t('"Nickname" field name'), "ExternalDbAuth_user_nickname") ?>
      <?= $this->form->text("ExternalDbAuth_user_nickname", $values, array()) ?>

      <!-- email -->
      <?= $this->form->label(t('"Email" field name'), "ExternalDbAuth_user_email") ?>
      <?= $this->form->text("ExternalDbAuth_user_email", $values, array()) ?>

      <!-- active -->
      <?= $this->form->label(t('"User active" field name'), "ExternalDbAuth_user_active") ?>
      <?= $this->form->text("ExternalDbAuth_user_active", $values, array()) ?>

      <!-- Invert active -->
      <?= $this->form->label(t('"User active" logic'), "ExternalDbAuth_user_active_logic") ?>
      <?= $this->form->radios(
        "ExternalDbAuth_user_active_logic",
        [
          "block" => t('"Block" logic (0 user enabled, 1 user disabled)'),
          "active" => t('"Active" logic (1 user enabled, 0 user disabled)'),
        ],
        $values
        ) ?>
    </fieldset>

    <fieldset>
      <legend><?= t('Groups table') ?></legend>
      <!-- table -->
      <?= $this->form->label(t('Table name for groups'), "ExternalDbAuth_group_table") ?>
      <?= $this->form->text("ExternalDbAuth_group_table", $values, array(), ["required"]) ?>

      <!-- ID -->
      <?= $this->form->label(t('"ID" field name'), "ExternalDbAuth_group_id") ?>
      <?= $this->form->text("ExternalDbAuth_group_id", $values, array(), ["required"]) ?>

      <!-- Name -->
      <?= $this->form->label(t('"Name" field name'), "ExternalDbAuth_group_name") ?>
      <?= $this->form->text("ExternalDbAuth_group_name", $values, array(), ["required"]) ?>
    </fieldset>

    <fieldset>
      <legend><?= t('User-group mapping table') ?></legend>

      <!-- table -->
      <?= $this->form->label(t('Table name for user-group mapping'), "ExternalDbAuth_mapping_table") ?>
      <?= $this->form->text("ExternalDbAuth_mapping_table", $values, array(), ["required"]) ?>

      <!-- User -->
      <?= $this->form->label(t('"User" field'), "ExternalDbAuth_mapping_user") ?>
      <?= $this->form->text("ExternalDbAuth_mapping_user", $values, array(), ["required"]) ?>

      <!-- User type -->
      <?= $this->form->label(t('"User" field content'), "ExternalDbAuth_mapping_user_type") ?>
      <?= $this->form->radios(
        "ExternalDbAuth_mapping_user_type",
        [
          "name" => t('Name of the user'),
          "id" => t('ID of the user'),
        ],
        $values
        ) ?>

      <!-- Group -->
      <?= $this->form->label(t('"Group" field'), "ExternalDbAuth_mapping_group") ?>
      <?= $this->form->text("ExternalDbAuth_mapping_group", $values, array(), ["required"]) ?>

      <!-- Group type -->
      <?= $this->form->label(t('"Group" field content'), "ExternalDbAuth_mapping_group_type") ?>
      <?= $this->form->radios(
        "ExternalDbAuth_mapping_group_type",
        [
          "name" => t('Name of the group'),
          "id" => t('ID of the group'),
        ],
        $values
        ) ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</form>
