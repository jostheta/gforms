<div style="margin: 0 10%;">
    <h1>Published Forms</h1>

    <table>
        <thead>
            <tr>
                <th>Form Title</th>
                <th>Created At</th>
                <th>Response Links</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($forms)) : ?>
                
               <?php foreach ($forms as $form) : ?>
                    <?php if ($form->is_published == 1) : ?>
                        <tr>
                        <td><a href="<?= base_url() ?>forms/list_form_responses/<?=$form->form_id?>"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></a></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($form->created_at)) ?></td>
                        <td><a href="<?= $form->response_link ?>"><?= $form->response_link ?></a></td>
                        </tr>
                    <?php endif; ?>  
              <?php endforeach; ?>
                
            <?php else : ?>
                <tr>
                    <td colspan="3">No forms found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>