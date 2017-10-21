<?php

return [
    'comment_form' => [
        // Change the title of send button
        'label_submit' => __( 'Send', 'textdomain' ),
        // Change the title of the reply section
        'title_reply' => __( 'Write a Reply or Comment', 'textdomain' ),
        // Remove "Text or HTML to be displayed after the set of comment fields".
        'comment_notes_after' => '',
        'comment_field' => '
          <div class="form-group">
            <label for="comment">' . _x( 'Comment', 'sage' ) . '</label>
            <br />
            <textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea>
          </div>',
        'fields' => [
          'author' => '
            <div class="form-group row">
              <label for="author" class="col-2 col-form-label">' . _x( 'Name', 'sage' ) . '</label>
              <div class="col-10">
                <input type="text" class="form-control" id="author" name="author" maxlength="245" required>
                <div class="invalid-feedback">
                    Please provide a valid name.
                </div>
              </div>
            </div>',
          'email' => '
            <div class="form-group row">
              <label for="email" class="col-2 col-form-label">' . _x( 'Email', 'sage' ) . '</label>
              <div class="col-10">
                <input type="email" class="form-control" id="email" name="email" maxlength="245" aria-required="true" required="required">
              </div>
              <div class="invalid-feedback">
                  Please provide a valid email.
              </div>
            </div>',
          'url' => '
            <div class="form-group row">
              <label for="url" class="col-2 col-form-label">' . _x( 'Url', 'sage' ) . '</label>
              <div class="col-10">
                <input class="form-control" type="url" value="" id="url">
              </div>
            </div>',
        ],
    ],
];
