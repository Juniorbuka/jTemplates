<div class="container container-body px-0">
    <p class="px-3"><?= $this->lang['builder.edit_config'] ?? 'Edit config' ?>: <strong><?= $data['filename'] ?? '' ?></strong></p>

    <div class="section-editor clearfix">
        <textarea name="jtemplates_builder_code" id="jtemplates_builder_code" rows="40"
                  onchange="documentDirty=true;"><?= $data['config'] ?? '' ?></textarea>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (window['myCodeMirrors'] && window['myCodeMirrors']['post']) {
      var config = window['myCodeMirrors']['post']['options']

      window['myCodeMirrors']['jtemplates_builder_code'] = CodeMirror.fromTextArea(
        document.getElementById('jtemplates_builder_code'),
        {
          mode: 'php',
          theme: config['theme'],
          defaulttheme: config['defaulttheme'],
          darktheme: config['darktheme'],
          indentUnit: config['indentUnit'],
          tabSize: config['tabSize'],
          lineNumbers: config['lineNumbers']
        }
      )
    }
  })
</script>
