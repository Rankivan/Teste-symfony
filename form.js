"use strict";

var Teste = {

  form: {

    urlForm: '',
    urlSalvar: '',
    urlIndex: '',

    init: function (config) {

      Teste.form.urlForm   = config.urlForm;
      Teste.form.urlSalvar = config.urlSalvar;
      Teste.form.urlIndex  = config.urlIndex;


      this.bindEvents();
    },

    bindEvents: function () {

      $('[name=valor]').inputmask({mask: "999999999", placeholder: ""});

      // Esconde o loading
      $('#loading-image').hide();

      $('#btn-limpar').off('click').on('click', function (e) {
        e.preventDefault();
        Teste.form.cleanForm();
      });

      Teste.form.formValidation();
    },

    cleanForm: function () {
      $('#nome, #valor').val(null).trigger('change');
    },

    formValidation: function () {

      $('#cadastro').validate({
        rules:    {
          nome:      {required: true},
          valor:      {required: true}
        },
        messages: {
          nome: {
            required: 'Este Campo é obrigatório!'
          },
          valor: {
            required: 'Este Campo é obrigatório!'
          }
        },
        submitHandler: function (form) {
          Teste.form.gravar();
        }
      });

    },

    gravar: function (form) {

      $.ajax({
        url: Teste.form.urlSalvar,
        type: 'POST',
        data: {
          testeId     : $('#testeId').val(),
          nome        : $('#nome').val(),
          valor       : $('#valor').val(),
        },
        success: function (result) {
          // window.location.href = Teste.form.urlForm + '/' + result.id;
          window.location.href = Teste.form.urlIndex;
          $("#loading-image").show();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          $("#loading-image").hide();

          var err = JSON.parse(xhr.responseText);
          toastr.error(err.message, "Erro");
        }
      });

    }

  }
};

$(document).ready(function () {
  $(function () {
    Teste.form.init({
      urlForm: $('#hdn-url-form').val(),
      urlSalvar: $('#hdn-url-salvar').val(),
      urlIndex: $('#hdn-url-index').val()
    });
  });
});