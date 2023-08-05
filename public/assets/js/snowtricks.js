window.onload = () => {
    const images_form = document.querySelector('#images-form');
    const videos_form = document.querySelector('#videos-form');
    const alert_uk = document.querySelectorAll('.uk-alert-danger');

    if (alert_uk)
    {
        alert_uk.forEach(alert => {
            if (!alert.querySelector('ul'))
            {
                alert.remove();
            }
        });
    }

    let html_image = `<div class="uk-padding-small" uk-margin>
        <div uk-form-custom="target: true">
            <input type="file" accept=".jpg, .png, .jpeg" name="trick_form[images][][file]">
            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select an image" aria-label="Custom controls" disabled>
        </div>
        <input type="text" class="uk-input" name="trick_form[images][][alt]" placeholder="Alternative text">

        <button class="uk-button uk-button-danger remove-image" uk-icon="trash"></button>
    </div>`;

    let html_video = `<div class="uk-padding-small" uk-margin>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: video-camera"></span>
            <input class="uk-input" inputmode="url" placeholder="Video Url" type="url" name="trick_form[videos][]">
        </div>
        
        <button class="uk-button uk-button-danger remove-video" uk-icon="trash"></button>
    </div>`;

    window.onclick = (e) => {

        /* =============== IMAGE =============== */
        add_remove_media(images_form, html_image, e, 'add-image', 'remove-image')
        /* =============== END IMAGE =============== */

        /* =============== VIDEO =============== */
        add_remove_media(videos_form, html_video, e, 'add-video', 'remove-video')
        /* =============== END VIDEO =============== */
    }
}

function add_remove_media(form, html, e, class_add, class_remove)
{
    // Don't remove first select media
    if (e.target.classList.contains(class_remove) && e.target.parentElement.classList.contains('not-remove')) return;
    if (e.target.parentElement.classList.contains(class_remove) && e.target.parentElement.parentElement.classList.contains('not-remove')) return;

    // Remove select media
    if (e.target.classList.contains(class_remove))
    {
        e.preventDefault();
        e.target.parentElement.remove();
    }

    if (e.target.parentElement.classList.contains(class_remove))
    {
        e.preventDefault();
        e.target.parentElement.parentElement.remove();
    }

    // Add select media
    if (e.target.classList.contains(class_add))
    {
        e.preventDefault();
        form.insertAdjacentHTML('afterend', html);
    }

    if (e.target.parentElement.classList.contains(class_add))
    {
        e.preventDefault();
        form.insertAdjacentHTML('afterend', html);
    }
}