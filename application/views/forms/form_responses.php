
    <div style="margin: 0 10%;">
    <h1>Responses for: <?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></h1>
    <a href="<?php echo base_url('responses/index/' . $form->form_id); ?>">View responses Question wise</a>

    <table>
        <thead>
            <tr>
                <th>Response ID</th>
                <th>User Name</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($responses)) : ?>
                <?php foreach ($responses as $response) : ?>
                    <tr>
                        <td><?= $response->response_id ?></td>      
                        <td><a href="<?= base_url('forms/view_response/' . $response->response_id) ?>"><?= $response->username ?></a></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($response->submitted_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="2">No responses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

