// GitHub- sohelrn
$(function () {
  $('.sidebar-menu a.nav-link').each(function () {
    if (this.href.split(/[?#]/)[0] === window.location.href.split(/[?#]/)[0]) {
      $(this).closest('a').addClass('actived');
    }
  });
  $('select[data-selected]').each(function () {
    if ($(this).data('selected')) $(this).find('option[value=' + $(this).data('selected') + ']').prop("selected", true);
  });
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  $('[data-toggle]').click(function () { $($(this).data('toggle')).slideToggle(200); });
  $('[data-bs-toggle=tooltip]').tooltip();

  $('form.form').on('submit', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var btn = $(this).find('button[type="submit"]');
    var txt = btn.html();
    var ltx = btn.is('[data-loader]') ? btn.data('loader') : '';
    if ($(this)[0].checkValidity() === true) {
      btn.prop('disabled', true);
      btn.addClass('disabled');
      btn.html('<span class="spinner-border spinner-border-sm me-1" style="border-width: 2px"></span> ' + ltx);
      setTimeout(function () { btn.html(txt); btn.prop('disabled', false); btn.removeClass('disabled'); }, 30000);
      $(this)[0].submit();
    }
    $(this).addClass('was-validated');
  });

  $('.btn-spinner').click(function (e) {
    var btn = $(this);
    var txt = btn.html();
    var ltx = btn.is('[data-loader]') ? btn.data('loader') : '';
    btn.html('<span class="spinner-border spinner-border-sm me-1" style="border-width: 2px"></span> ' + ltx);
    setTimeout(function () { btn.html(txt); }, 15000);
  });

  $('#email-login-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var usr = frm.find('input[name=email]').val();
    var pas = frm.find('input[name=password]').val();
    if (usr.length < 3) return;
    err.empty();
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/login", { user: usr, pass: pas }, function (data) {
      if (data.status) {
        location.href = $('#email-login').is('[data-redirect]') ? $('#email-login').data('redirect') : 'my';
      } else if (data.verification) {
        $('#email-login').hide();
        $('#device-verification-form').show();
        $('#device-verification-form').find('input[name=username]').val(data.username);
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#device-verification-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var cod = frm.find('input[name=verification_code]').val();
    err.empty();
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/login_verification", { code: cod }, function (data) {
      if (data.status) {
        location.href = $('#email-login').is('[data-redirect]') ? $('#email-login').data('redirect') : 'my';
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#email-signup-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var pas = frm.find('input[name=password]').val();
    err.empty();
    if (pas.length < 8) {
      err.html("Password must be at least 8 characters.");
      return;
    }
    if (pas != frm.find('input[name=confirm_password]').val()) {
      err.html("Confirm password don't match.");
      return;
    }
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/signup", frm.serialize(), function (data) {
      if (data.status) {
        location.reload();
      } else if (data.verification) {
        $('#email-signup').hide();
        $('#email-verification-form').show();
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#email-verification-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var cod = frm.find('input[name=verification_code]').val();
    err.empty();
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/signup_verification", { code: cod }, function (data) {
      if (data.status) {
        location.reload();
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#pass-reset-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var usr = frm.find('input[name=email]').val();
    err.empty();
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/reset", { user: usr }, function (data) {
      if (data.status) {
        $('#pass-reset-success').html(data.message).show();
        $('#pass-reset-form').hide();
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#password-update-form').submit(function (e) {
    e.preventDefault();
    var frm = $(this);
    var btn = frm.find('button[type=submit]');
    var txt = btn.html();
    var err = frm.find('.error-message');
    var tok = btn.data('token');
    var pas = frm.find('input[name=password]').val();
    err.empty();
    if (pas.length < 8) {
      err.html("Password must be at least 8 characters.");
      return;
    }
    if (pas != frm.find('input[name=confirm_password]').val()) {
      err.html("Confirm password don't match.");
      return;
    }
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("data/password_update", { pass: pas, token: tok }, function (data) {
      if (data.status) {
        $('#pass-change-success').html(data.message).show();
        $('#password-update-form').hide();
        window.setTimeout(function () { location.reload(); }, 3000);
      } else {
        err.html(data.message);
        btn.prop('disabled', false);
        btn.html(txt);
      }
    }).fail(function () {
      err.html('Something went wrong, try again.');
      btn.prop('disabled', false);
      btn.html(txt);
    }, "json");
  });

  $('#contact-form').submit(function () {
    var form = $(this);
    form.find('#result').empty();
    form.find('button').attr("disabled", "disabled");
    $.post("contact?token=" + form.data("token"), form.serialize(), function (data) {
      if (data == 'success') {
        form.find('#result').html('<div class="alert alert-success"><strong>Thank you!</strong> Your message has been sent successfully.</div>');
        form.trigger("reset");
      } else {
        form.find('#result').html('<div class="alert alert-danger"><strong>Sorry</strong>, it seems that my mail server is not responding. Please try again.</div>');
      }
      form.find('button').removeAttr("disabled");
    }).fail(function () {
      form.find('button').removeAttr("disabled");
    });
    return false;
  });

  $('button.input-file-button').click(function (e) {
    e.preventDefault();
    var parent = $($(this).data('target'));
    var input = parent.find('.input-file[type="file"]');
    input.unbind('change').click();
    input.change(function (e) {
      if (e.target.files.length > 0) {
        if (e.target.files[0].size > 5242880 || $.inArray(e.target.files[0]['type'], ["image/jpg", "image/jpeg", "image/png", "image/webp", "image/svg+xml"]) < 0) {
          input.val(null);
          parent.find('.upload_error').html('<span class="text-danger">Upload failed. Please check the file format and size and try again.</span>').show();
          return;
        }
        var data = new FormData();
        var reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function (e) {
          parent.find('img').attr('src', e.target.result);
          parent.find('img').css({
            opacity: 0.4
          });
        };
        parent.find('.input-file-add').hide();
        parent.find('.input-file-thumbnail').show();
        parent.closest('div').next().find('button.input-file-button').removeAttr("disabled");
        data.append(input.attr('name'), e.target.files[0]);
        var url = window.location.href;
        var separator = (url.indexOf('?') !== -1) ? '&' : '?';
        $.ajax({
          url: url + separator + 'upload=' + input.attr('name'),
          method: 'POST',
          data: data,
          contentType: false,
          processData: false,
          beforeSend: function () {
            parent.find('.upload_error').html(null).hide();
            parent.find('.spinner').addClass('spinner-border');
            parent.find('.spinner').show();
            parent.attr('data-uploading', true);
          },
          success: function (response) {
            if (response) {
              try {
                data = JSON.parse(response);
                parent.find('.input-file-thumbnail img').attr('src', data['url']);
                parent.find('.input-file-url[type="hidden"]').val(data['url']);
                parent.find('.input-file-id[type="hidden"]').val(data['id']);
                error = false;
              } catch (e) {
                error = true;
              }
            } else {
              error = true;
            }
            if (error) {
              parent.find('.input-file-add').show();
              parent.find('.input-file-thumbnail').hide();
              parent.find('.input-file-thumbnail img').removeAttr('src');
              parent.closest('div').next().find('button.input-file-button').attr("disabled", "disabled");
              parent.find('.upload_error').html('<span class="text-danger">Upload failed. Something went wrong, try again.</span>').show();
            }
          },
          complete: function () {
            input.val(null);
            parent.find('.spinner').hide();
            parent.find('.spinner').removeClass('spinner-border');
            parent.removeAttr('data-uploading');
            parent.find('img').css({
              opacity: 1
            });
          }
        });
      }
    });
  });

  $('button.input-file-remove').click(function (e) {
    var parent = $(this).parents('.raitor-input-file');
    parent.find('.input-file-add').show();
    parent.find('.input-file-thumbnail').hide();
    parent.find('.input-file[type="file"]').val(null);
    parent.find('.input-file-thumbnail img').removeAttr('src');
    parent.closest('div').next().find('button.input-file-button').attr("disabled", "disabled");
    $.post(window.location.href.split('?')[0] + '?remove=image', {
      imageId: parent.find('.input-file-id[type="hidden"]').val()
    }, function (response) { });
    parent.find('.input-file-id[type="hidden"]').val(null);
  });

  $('.delete_doc').click(function (e) {
    $(this).closest('tr').fadeOut();
    $.get("", { del_id: $(this).data('id') });
  });

  $('.rename_doc').click(function (e) {
    var doc = $(this).data('id');
    var nam = $('#name_' + doc).html();
    $('#rename').find('input[name=name]').val(nam);
    $('#rename').find('#rename_doc').attr('data-doc', doc);
  });

  $('#rename_doc').click(function (e) {
    e.preventDefault();
    var nam = $(this).parents().find('input[name=name]').val();
    var doc = $(this).data('doc');
    $('#name_' + doc).html(nam);
    $.get("", { name: nam, doc_id: doc });
  });

  $('#currency_select').change(function (e) {
    $.get("", { 'currency': $(this).val() }, function (response) {
      var o = JSON.parse(response);
      var s = o.discern ? o.discern : o.symbol;
      var p = o.ltr == 'true' ? 'left' : 'right';
      $('#currency_symbol_text').val(s);
      $('#currency_position_select option[value=' + p + ']').prop('selected', true);
    });
  });

  if ($('#raitor-editor').length) {
    var toolbarOptions = [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block'],
      [{ 'list': 'ordered' }, { 'list': 'bullet' }],
      [{ 'script': 'sub' }, { 'script': 'super' }],
      [{ 'indent': '-1' }, { 'indent': '+1' }],
      [{ 'color': [] }, { 'background': [] }],
      [{ 'align': [] }],
      ['clean']
    ];
    var quill = new Quill('#raitor-editor', {
      modules: { toolbar: toolbarOptions },
      theme: 'snow'
    });
  }

  $('#templateSearch').on('input', function () {
    var searchText = $(this).val().toLowerCase();
    $('.templateTitle').each(function () {
      var titleText = $(this).text().toLowerCase();
      var templateItem = $(this).closest('.templateItem');
      if (titleText.includes(searchText)) {
        templateItem.show();
      } else {
        templateItem.hide();
      }
    });
  });

  $('#templateBack').on('click', function () {
    const currentUrl = new URL(window.location.href);
    const searchParams = currentUrl.searchParams;
    searchParams.delete('t');
    const newUrl = currentUrl.origin + currentUrl.pathname + '?' + searchParams.toString() + currentUrl.hash;
    history.pushState({}, '', newUrl);
    $('#templateForm').hide();
    $('#templateArea').show();
  });

  $('#templateArea a').on('click', function (e) {
    e.preventDefault();
    var id = $(this).data('template');
    const currentUrl = window.location.href;
    const urlObject = new URL(currentUrl);
    urlObject.searchParams.set('t', id);
    history.pushState({}, '', urlObject.toString());
    $('#templateArea').hide();
    $('#templateForm').show();
    $('#templateForm form').html(null);
    $('#templateLoading').remove();
    $('#templateForm').append('<div id="templateLoading" class="d-flex justify-content-center align-items-center mt-5"><div class="spinner-border" role="status"></div></div>');
    $.get(window.location.href, {
      tid: id
    }, function (data) {
      $('#templateForm form').html(data);
    }).done(function () {
      $('#templateLoading').remove();
    });
  });

  $('#smart-editor').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    var txt = btn.html();
    var error = false;
    $(this).find('.form-control[required]').each(function () {
      if ($(this).val().trim().length < 1) {
        $(this).addClass('form-control-error');
        $('#input-required-modal').modal('show');
        error = true;
      } else {
        $(this).removeClass('form-control-error');
      }
    });
    if (error) return;
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("", $(this).serialize(), function (data) {
      if (data.results) {
        data.results.forEach((text) => {
          var range = quill.getSelection();
          if (range) {
            quill.insertText(range.index, text);
          } else {
            quill.insertText(quill.getLength(), text + "\r\n");
          }
        });
        $('#credit-words').html(data.credits);
        // scroll
        if ($(window).innerWidth() < 787) {
          $([document.documentElement, document.body]).animate({ scrollTop: $('.raitor-editor').offset().top }, 500);
        }
        setTimeout(function () {
          $('.raitor-editor .ql-editor').animate({ scrollTop: $('.raitor-editor .ql-editor')[0].scrollHeight }, 1000);
        }, 500);
      } else if (data.error == 'no_credits') {
        $('#no-credits').show();
        $('#no-credits-modal').modal('show');
        btn.addClass('disabled');
      } else if (data.error == 'no_access') {
        $('#no-access-modal').modal('show');
      } else {
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      btn.prop('disabled', false);
      btn.html(txt);
    }).fail(function () {
      btn.prop('disabled', false);
      btn.html(txt);
      $('#result-error-modal').modal('show');
    }, "json");
  });

  $('#text-generator').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    var btn = $(this).find('button[type=submit]');
    var error = false;
    var loop = 1;
    var txt = btn.html();
    $(this).find('.form-control[required]').each(function () {
      if ($(this).val().trim().length < 1) {
        $(this).addClass('form-control-error');
        $('#input-required-modal').modal('show');
        error = true;
      } else {
        $(this).removeClass('form-control-error');
      }
    });
    if (error) return;
    new bootstrap.Tab($('[data-bs-target="#result-tab-pane"]')).show();
    $('#result-info').hide();
    $('#result-error').hide();
    $('#no-credits').hide();
    btn.html('<span class="spinner-border spinner-border-sm me-1" style="border-width: 2px"></span>');
    btn.prop('disabled', true);
    if ($(window).innerWidth() < 787 && $('#result-tab-pane').length) {
      $([document.documentElement, document.body]).animate({ scrollTop: $('#result-tab-pane').offset().top - 145 }, 500);
    }
    // GitHub- sohelrn
    var rid = Math.random().toString(16).slice(2);
    $('#response .response-message').clone().prependTo("#results").show().attr("id", rid);
    $.post("", $this.serialize() + "&request=" + loop, function (data) {
      // tooltip
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
      if (data.id) {
        let text = '';
        let wordCount = 0;
        var url = window.location.href.split('?')[0] + '?id=' + data.id;
        $('#' + rid).find('button').attr('data-id', data.id);
        eventSource = new EventSource(url);
        eventSource.onopen = function (e) {
          $('#' + rid + ' .ai-content').addClass('result-streaming');
        };
        eventSource.onmessage = function (e) {
          $('#' + rid + ' .result-thinking').remove();
          if (e.data == "[DONE]") {
            btn.prop('disabled', false);
            eventSource.close();
            $('#credit-words').html(Math.round(data.credits - (wordCount * 0.75)));
            $('#' + rid + ' .ai-content').removeClass('result-streaming');
            Prism.highlightAll();
          } else {
            let content = JSON.parse(e.data).choices[0].delta.content;
            if (content !== undefined) {
              wordCount++;
              text += content;
              $('#' + rid + ' .ai-content').append(content.replace(/(?:\r\n|\r|\n)/g, '<br>'));
              $('#' + rid + ' .markdown').html(markdown(text));
            }
          }
        };
        eventSource.onerror = function (e) {
          eventSource.close();
          btn.prop('disabled', false);
        };
      } else if (data.error == 'no_credits') {
        $('#' + rid).remove();
        $('#no-credits').show();
        $('#no-credits-modal').modal('show');
      } else {
        $('#' + rid).remove();
        btn.prop('disabled', false);
        $('#result-error').show();
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      btn.html(txt);
      //btn.prop('disabled', false);
    }).fail(function () {
      btn.html(txt);
      btn.prop('disabled', false);
      $('#' + rid).remove();
      $('#result-error').show();
      $('#result-error-modal').modal('show');
    }, "json");
  });

  $('#image-generator').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    var txt = btn.html();
    var error = false;
    $(this).find('.form-control[required]').each(function () {
      if ($(this).val().trim().length < 1) {
        $(this).addClass('form-control-error');
        $('#input-required-modal').modal('show');
        error = true;
      } else {
        $(this).removeClass('form-control-error');
      }
    });
    if (error) return;
    $('#result-info').hide();
    $('#result-error').hide();
    $('#no-credits').hide();
    $('.loading').remove();
    var htm = '<div class="col-6 col-xl-4 col-xxl-3 img-placeholder placeholder-glow loading"><div class="card w-100 h-100 placeholder" style="min-height:200px"></div></div>';
    $('#results').prepend(htm).show();
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $.post("", $(this).serialize(), function (data) {
      if (data.results) {
        data.results.forEach((text) => {
          $('#results').prepend(text).show();
        });
        $('#credit-words').html(data.credits);
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        document.querySelectorAll('[data-toggle="lightbox"]').forEach(el => el.addEventListener('click', Lightbox.initialize));
      } else if (data.error == 'no_credits') {
        $('#no-credits').show();
        $('#no-credits-modal').modal('show');
        btn.addClass('disabled');
      } else {
        $('#result-error').show();
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      $('.loading').remove();
      btn.html(txt);
      btn.prop('disabled', false);
    }).fail(function () {
      $('.loading').remove();
      btn.html(txt);
      btn.prop('disabled', false);
    }, "json");
  });

  $('#article-generator').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    var txt = btn.html();
    var error = false;
    $(this).find('.form-control[required]').each(function () {
      if ($(this).val().trim().length < 3) {
        $('#input-required-modal').modal('show');
        error = true;
      }
    });
    if (error) return;
    btn.prop('disabled', true);
    btn.html('<span class="spinner-border spinner-border-sm" style="border-width: 2px"></span>');
    $('.ai-content').empty();
    $.post("", $(this).serialize(), function (data) {
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
      if (data.id) {
        $('#info').hide();
        $('#results').show();
        let text = '';
        let wordCount = 0;
        var url = window.location.href.split('?')[0] + '?id=' + data.id;
        eventSource = new EventSource(url);
        eventSource.onopen = function (e) {
          $('#results button').prop('disabled', true);
          $('.result-thinking').remove();
          $('.ai-content').addClass('result-streaming');
        };
        eventSource.onmessage = function (e) {
          if (e.data == "[DONE]") {
            eventSource.close();
            $('#results button').prop('disabled', false);
            $('#credit-words').html(Math.round(data.credits - (wordCount * 0.75)));
            $('.ai-content').removeClass('result-streaming');
            btn.prop('disabled', false);
            Prism.highlightAll();
          } else {
            let content = JSON.parse(e.data).choices[0].delta.content;
            if (content !== undefined) {
              wordCount++;
              text += content;
              $('.ai-content').append(content.replace(/(?:\r\n|\r|\n)/g, '<br>'));
              $('.markdown').html(markdown(text));
            }
          }
        };
        eventSource.onerror = function (e) {
          eventSource.close();
          $('#results button').prop('disabled', false);
          btn.prop('disabled', false);
        };
      } else if (data.error == 'no_credits') {
        $('#results button').prop('disabled', false);
        $('#no-credits-modal').modal('show');
      } else {
        btn.prop('disabled', false);
        $('#results button').prop('disabled', false);
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      btn.html(txt);
    }).fail(function () {
      btn.html(txt);
      $('#result-error-modal').modal('show');
    }, "json");
  });

  $('#back-article').click(function (e) {
    $('#results').hide();
    $('#info').show();
    $('#info').show();
  });

  $('#content-rewriter').on('submit', function (e) {
    e.preventDefault();
    var btn = $(this).find('button[type=submit]');
    var txt = btn.html();
    var error = false;
    $(this).find('.form-control[required]').each(function () {
      if ($(this).val().trim().length < 10) {
        $('#input-required-modal').modal('show');
        error = true;
      }
    });
    if (error) return;
    $('.ai-content').empty();
    btn.prop('disabled', true);
    $.post("", $(this).serialize(), function (data) {
      // tooltip
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
      if (data.id) {
        $('#results').show();
        $('html, body').animate({ scrollTop: $("#results").offset().top }, 500);
        let text = '';
        let wordCount = 0;
        var url = window.location.href.split('?')[0] + '?id=' + data.id;
        eventSource = new EventSource(url);
        eventSource.onopen = function (e) {
          $('#results button').prop('disabled', true);
          $('.result-thinking').remove();
          $('.ai-content').addClass('result-streaming');
          setTimeout(function () {
            $('html, body').animate({ scrollTop: $("#results").offset().top }, 500);
          }, 1000);
          setTimeout(function () {
            $('html, body').animate({ scrollTop: $("#results").offset().top - 130 }, 500);
          }, 3000);
          setTimeout(function () {
            $('html, body').animate({ scrollTop: $("#results").offset().top - 130 }, 500);
          }, 5000);
        };
        eventSource.onmessage = function (e) {
          if (e.data == "[DONE]") {
            eventSource.close();
            btn.prop('disabled', false);
            $('.ai-content').removeClass('result-streaming');
            $('#results button').prop('disabled', false);
            $('#credit-words').html(Math.round(data.credits - (wordCount * 0.75)));
          } else {
            let content = JSON.parse(e.data).choices[0].delta.content;
            if (content !== undefined) {
              wordCount++;
              text += content;
              $('.ai-content').append(content.replace(/(?:\r\n|\r|\n)/g, '<br>'));
              $('.markdown').html(markdown(text));
            }
          }
        };
        eventSource.onerror = function (e) {
          eventSource.close();
          btn.prop('disabled', false);
          $('#results button').prop('disabled', false);
        };

      } else if (data.error == 'no_credits') {
        $('#no-credits-modal').modal('show');
        btn.addClass('disabled');
      } else {
        btn.prop('disabled', false);
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      btn.html(txt);
    }).fail(function () {
      btn.html(txt);
      btn.prop('disabled', false);
      $('#result-error-modal').modal('show');
    }, "json");
  });

  // Enable form submit
  let formSubmit = true;
  let autoScroll = true;
  // Initialize SimpleBar if .chat-body exists
  let simpleBar;
  const chatBody = document.querySelector('.chat-body');
  if (chatBody) {
    simpleBar = new SimpleBar(chatBody);
  }

  $('#chat').on('submit', function (e) {
    e.preventDefault();
    if (!formSubmit) return;
    formSubmit = false;
    var rid = Math.random().toString(16).slice(2);
    var $this = $(this);
    var usr = $this.data('user');
    var btn = $this.find('button[type=submit]');
    var pmt = $this.find('#prompt-input').val();
    if (pmt.trim().length < 1) {
      $('#input-required-modal').modal('show');
      return;
    }
    btn.prop('disabled', true);
    $('#prompt-input').val('');
    $('#prompt-input').css({ height: "56px", overflow: "hidden" });
    $('#result-info').hide();
    $('#result-error').hide();
    $('#no-credits').hide();
    $('#prompt-library').hide();
    $('#user-response .user-message').clone().appendTo("#chat-message").show().attr("id", 'user_' + rid);
    $('#user_' + rid + ' .ai-content').html(pmt.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/(?:\r\n|\r|\n)/g, '<br>'));
    $('#response .response-message').clone().appendTo("#chat-message").show().attr("id", rid);

    $('.chat-footer .fileItem').each(function () {
      var clonedItem = $(this).clone();
      $('#user_' + rid + ' .chat-content').append(clonedItem);
    });
    $('.chat-footer .fileItem').remove();

    simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    $.post("", { prompt: pmt, id: $this.attr('data-id') }, function (data) {
      if (data.id) {
        let text = '';
        let wordCount = 0;
        var url = window.location.href.split('?')[0] + '?id=' + data.id;
        $this.attr('data-id', data.id);
        eventSource = new EventSource(url);
        eventSource.onopen = function (e) {
          $('#' + rid + ' .ai-content').addClass('result-streaming');
        };
        eventSource.onmessage = function (e) {
          $('#' + rid + ' .result-thinking').remove();
          if (e.data == "[DONE]") {
            eventSource.close();
            formSubmit = true;
            $('#credit-words').html(Math.round(data.credits - (wordCount * 0.75)));
            $('#' + rid + ' .ai-content').removeClass('result-streaming');
            $('#' + rid + ' .chat-action').show();
            const currentUrl = window.location.href;
            const urlObject = new URL(currentUrl);
            urlObject.searchParams.set('c', data.id);
            history.pushState({}, '', urlObject.toString());
            Prism.highlightAll();
            if (autoScroll) {
              simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
            }
          } else {
            let content = JSON.parse(e.data).choices[0].delta.content;
            if (content !== undefined) {
              wordCount++;
              text += content;
              $('#' + rid + ' .ai-content').append(content.replace(/(?:\r\n|\r|\n)/g, '<br>'));
              $('#' + rid + ' .markdown').html(markdown(text));
              if (autoScroll) {
                simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
              }
            }
          }
        };
        eventSource.onerror = function (e) {
          eventSource.close();
          formSubmit = true;
          btn.prop('disabled', false);
        };
        if ($('.chat-title').is(':empty')) {
          $('.chat-title').html(pmt.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;'));
          $('.chat-title').parents('li').fadeIn();
          $('.chat-title').parents('li').find('.rename_chat').data('id', data.id);
          $('.chat-title').parents('li').find('.delete_chat').data('id', data.id);
          $('.chat-title').attr('id', 'name_' + data.id);
        }
      } else if (data.error == 'no_credits') {
        $('#' + rid).remove();
        $('#no-credits-modal').modal('show');
        btn.addClass('disabled');
      } else {
        $('#' + rid).remove();
        formSubmit = true;
        btn.prop('disabled', false);
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
      //btn.prop('disabled', false);
    }).fail(function () {
      formSubmit = true;
      $('#result-error-modal').modal('show');
      $('#' + rid).remove();
    }, "json");
  });

  $('#analysis').on('submit', function (e) {
    e.preventDefault();
    if (!formSubmit) return;
    formSubmit = false;
    var rid = Math.random().toString(16).slice(2);
    var $this = $(this);
    var usr = $this.data('user');
    var btn = $this.find('button[type=submit]');
    var pmt = $this.find('#prompt-input').val();
    if (pmt.trim().length < 1) {
      $('#input-required-modal').modal('show');
      return;
    }
    btn.prop('disabled', true);
    $('#prompt-input').val('');
    $('#prompt-input').css({ height: "56px", overflow: "hidden" });
    $('#result-info').hide();
    $('#result-error').hide();
    $('#no-credits').hide();
    $('#prompt-library').hide();
    $('#user-response .user-message').clone().appendTo("#chat-message").show().find('.ai-content').html(pmt.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/(?:\r\n|\r|\n)/g, '<br>'));
    $('#response .response-message').clone().appendTo("#chat-message").show().attr("id", rid);
    const simpleBar = new SimpleBar(document.querySelector('.chat-body'));
    simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    $.post("", { prompt: pmt }, function (data) {
      if (data.id) {
        let text = '';
        let wordCount = 0;
        var url = window.location.href.split('?')[0] + '?id=' + data.id;
        $this.attr('data-id', data.id);
        eventSource = new EventSource(url);
        eventSource.onopen = function (e) {
          $('#' + rid + ' .ai-content').addClass('result-streaming');
        };
        eventSource.onmessage = function (e) {
          if (e.data == "[DONE]") {
            eventSource.close();
            formSubmit = true;
            $('#credit-words').html(Math.round(data.credits - (wordCount * 0.75)));
            $('#' + rid + ' .ai-content').removeClass('result-streaming');
            $('#' + rid + ' .chat-action').show();
            Prism.highlightAll();
            if (autoScroll) {
              simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
            }
          } else {
            let content = e.data;
            if (content !== undefined) {
              wordCount++;
              text += content.replace(/\\n/g, '\n');
              $('#' + rid + ' .result-processing').remove();
              $('#' + rid + ' .ai-content').append(content.replace(/\n/g, '<br>'));
              $('#' + rid + ' .markdown').html(markdown(text));
              if (autoScroll) {
                simpleBar.getScrollElement().scrollTop = simpleBar.getContentElement().scrollHeight;
              }
            }
          }
        };
        eventSource.onerror = function (e) {
          eventSource.close();
          formSubmit = true;
          btn.prop('disabled', false);
          $('#' + rid + ' .result-processing').remove();
        };
      } else if (data.error == 'no_credits') {
        $('#' + rid).remove();
        $('#no-credits-modal').modal('show');
        btn.addClass('disabled');
      } else {
        $('#' + rid).remove();
        formSubmit = true;
        btn.prop('disabled', false);
        $('#result-error-modal').modal('show');
        if (data.message) $('#result-error-modal .error-message').html(data.message);
      }
    }).done(function () {
    }).fail(function () {
      formSubmit = true;
      $('#result-error-modal').modal('show');
      $('#' + rid).remove();
    }, "json");
  });

  // Get references to the necessary elements
  const chatScroll = document.querySelector('.chat-scroll');
  const scrollDownBtn = document.getElementById('scrollDownBtn');
  const promptInput = document.getElementById('prompt-input');
  // Function to update chat-scroll position based on textarea height
  function updateChatScrollPosition() {
    const textareaHeight = promptInput.clientHeight;
    const newBottomPosition = 40 + textareaHeight;
    if (chatScroll) {
      chatScroll.style.bottom = `${newBottomPosition}px`;
    }
  }
  if (promptInput) {
    promptInput.addEventListener('input', () => {
      updateChatScrollPosition();
    });
    // Initial setup
    updateChatScrollPosition();
  }

  // scroll button
  if (scrollDownBtn) {
    simpleBar.getScrollElement().addEventListener('scroll', () => {
      const scrollElement = simpleBar.getScrollElement();
      const contentElement = simpleBar.getContentElement();
      const isAtBottom = scrollElement.scrollTop + scrollElement.clientHeight >= contentElement.scrollHeight - 10;
      autoScroll = isAtBottom;
      if (scrollElement.scrollTop + scrollElement.clientHeight < contentElement.scrollHeight - 10) {
        scrollDownBtn.style.display = 'block';
      } else {
        scrollDownBtn.style.display = 'none';
      }
    });
    scrollDownBtn.addEventListener('click', () => {
      const scrollElement = simpleBar.getScrollElement();
      const endOfContent = scrollElement.scrollHeight - scrollElement.clientHeight;
      scrollElement.scroll({
        top: endOfContent,
        behavior: 'smooth'
      });
      autoScroll = true;
    });
  }

  $('#fileInput').change(function () {
    var files = this.files;
    if (files.length > 0) {
      var formData = new FormData();
      for (var i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
      }
      $('#uploadError').hide();
      $('#UploadProgress').show();
      $('#fileHistory').show();
      $('#uploadButton').prop('disabled', true);
      $('#progressBar').width('0%');
      $('#progressBar').html('');
      $.ajax({
        url: '',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = (evt.loaded / evt.total) * 100;
              percentComplete = Math.min(Math.round(percentComplete), 99);
              $('#progressBar').width(percentComplete + '%');
              $('#progressBar').html(percentComplete + '%');
            }
          }, false);
          return xhr;
        },
        success: function (response) {
          if (response && typeof response === 'object') {
            if (response.files) {
              $('#progressBar').width('100%');
              $('#progressBar').html('100%');
              if (response.files && Array.isArray(response.files)) {
                response.files.forEach(function (file) {
                  var newItem = $('#fileItem').clone().removeAttr('id').addClass('fileItem').show();
                  newItem.find('.fileName').text(file.fileName);
                  newItem.find('.fileExtension').text(file.fileExtension);
                  newItem.find('.fileId').attr('data-id', file.fileId);
                  $('#fileItem').after(newItem);
                });
              }
            } else if (response.redirect) {
              window.location.href = response.redirect;
            } else if (response.error) {
              $('#uploadError').html(response.error).show();
            }
            $('#UploadProgress').hide();
            $('#progressBar').width('0%');
            $('#progressBar').html('');
          } else {
            $('#uploadError').show();
            $('#UploadProgress').hide();
          }
        },
        complete: function () {
          $('#fileInput').val('');
          $('#uploadButton').prop('disabled', false);
        },
        error: function () {
          $('#uploadError').show();
          $('#UploadProgress').hide();
        }
      });
    }
  });

  $('#uploadButton').click(function () {
    $('#fileInput').click();
  });

  $("#prompt-input").keypress(function (e) {
    if (e.which === 13 && !e.shiftKey) {
      e.preventDefault();
      $('#chat').submit();
      $('#analysis').submit();
    }
  });

  $(document).on("click", ".delete_file", function (e) {
    var id = $(this).data('id');
    $('#deleteFile').find('input[name=delete_file_id]').val(id);
  });

  $('.delete_chat').click(function (e) {
    var id = $(this).data('id');
    $('#delete').find('input[name=delete_id]').val(id);
  });

  $('.rename_chat').click(function (e) {
    var id = $(this).data('id');
    var nm = $('#name_' + id).html();
    $('#rename').find('input[name=name]').val(nm);
    $('#rename').find('button[type=submit]').attr('data-id', id);
  });

  $('#rename_chat').click(function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var nm = $(this).parents().find('input[name=name]').val();
    $('#name_' + id).html(nm);
    $.post("", { rename: nm, rename_id: id });
  });

  $(document).on("click", ".delete-history", function (e) {
    $(this).closest('.card').fadeOut();
    $.get("", { del_id: $(this).data('id') });
  });

  $(document).on("click", ".delete_img", function (e) {
    $(this).parents('.col-img').fadeOut();
    $.get("", { del_id: $(this).data('id') });
  });

  $('.remove-history').click(function (e) {
    $(this).closest('tr').fadeOut();
    $.get("", { del_id: $(this).data('id') });
  });

  $('#template-group button').click(function () {
    var target = $(this).data('bs-target');
    if (target == 'all') {
      $('#tab-content [data-category]').show();
    } else {
      $('#tab-content [data-category]').hide();
      $('#tab-content [data-category="' + target + '"]').show();
    }
  });

  $('#search-template').on('input', function () {
    var val = $(this).val().toLowerCase().trim().replace(/\s+/g, ' ');
    var searchWords = val.split(' ');
    $('[data-bs-target=all]').click();
    if (val.length > 0) {
      $('#tab-content h6').each(function () {
        var text = $(this).text().toLowerCase().replace(/\s+/g, ' ');
        var matched = true;
        searchWords.forEach(function (word) {
          if (text.indexOf(word) === -1) {
            matched = false;
          }
        });
        if (matched) {
          $(this).closest('[data-category]').show();
        } else {
          $(this).closest('[data-category]').hide();
        }
      });
    } else {
      $('#tab-content [data-category]').show();
    }
  });

  $('[data-bs-toggle=save]').click(function (e) {
    e.preventDefault();
    var btn = $('[data-bs-target="#save-as"]');
    var doc = btn.attr('data-doc');
    var nam = $('.doc-name').val() ? $('.doc-name').val() : $('#raitor-template').find(":selected").html();
    var txt = quill.root.innerHTML;
    btn.prop('disabled', true);
    $.post("", { doc: doc, name: nam, text: txt }, function (data) {
      if (data.doc) {
        btn.attr('data-doc', data.doc);
        btn.attr('data-bs-toggle', 'save');
      }
    }).done(function () {
      btn.prop('disabled', false);
    }).fail(function () {
      btn.prop('disabled', false);
    }, "json");
  });

  $('#down-txt').click(function (e) {
    var filename = "text.txt";
    var text = quill.getText();
    downloadFile(text, filename, 'plain/text');
  });
  $('#down-htm').click(function (e) {
    var filename = "text.html";
    var html = quill.root.innerHTML;
    downloadFile(html, filename, 'text/html');
  });
  $('#down-doc').click(function (e) {
    var filename = "text.doc";
    var html = quill.getText();
    downloadFile(html, filename, 'application/msword');
  });
  $('.markdown').html(function (index, text) {
    return markdown(text);
  });
  Prism.highlightAll();
  autosize(document.querySelectorAll('.autosize'));
});

$(window).scroll(function () {
  var sticky = $('#navbar');
  if ($(window).scrollTop() >= 20) sticky.addClass('navbar-sticky');
  else sticky.removeClass('navbar-sticky');
});

function downloadFile(filedata, filename, mimetype) {
  const element = document.createElement('a');
  const blob = new Blob([filedata], { type: mimetype });
  const fileUrl = URL.createObjectURL(blob);
  element.setAttribute('href', fileUrl);
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
};

var cookiepolicy = document.getElementById('gdpr-cookie-policy');
if (cookiepolicy) {
  cookiepolicy.addEventListener('hidden.bs.toast', () => {
    document.cookie = "_gdpr=yes; max-age=31536000; path=/";
  });
}