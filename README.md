# Сlient for API SonataMediaBundle
Symfony media client bundle for uploading (sending) files and images to a remote server deployed on SonataMediaBundle

Page bundle: https://github.com/Avtonom/media-storage-client-bundle

Run the following in your project root, assuming you have composer set up for your project

```sh

composer.phar require avtonom/media-storage-client-bundle ~1.2

```

Switching `~1.2` for the most recent tag.

Add the bundle to app/AppKernel.php

```php

$bundles(
    ...
    new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),
    new Avtonom\MediaStorageClientBundle\AvtonomMediaStorageClientBundle(),
    ...
);

```

Configuration options (parameters.yaml):

``` yaml

parameters:
    avtonom.media_storage_client:
        clients:
            client_name_url:
                base_url: http://demo.com
                add_media_url: /app_dev.php/api/providers/sonata.media.provider.url/media
            client_name_url:
                base_url: http://demo.com
                add_media_url: /app_dev.php/api/providers/sonata.media.provider.file/media
        urls:
            base_url: http://demo.com
            get_media_by_reference_full_url: /app_dev.php/api/media/referencefull
        listener:
            interfaces: ['Bundle\Model\EntityInterface1', 'Bundle\Model\EntityInterface2']
            change_field: my_change_field
            ignored_domains: ['s.dev.demo.com', 's.prod.demo.com']
            client: client_name_url
            context: context
        logging_level: 100

```

[Optionally] Configuration bower (\web\bower.json) to file upload:

```

"blueimp-file-upload-node": "*"

```

[Optionally] File js to file upload (for example: \src\Bundle\Resources\views\standard_layout.html.twig):
This example uses a library of x-editable (http://vitalets.github.io/x-editable/).

``` twig

{% block javascripts %}
    {{ parent() }}
    {% javascripts
        '@AvtonomMediaStorageClientBundle/Resources/public/js/actions.js'
    %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}

```


### Use alternative number 1: block to add a reference to the file

``` twig

<a href="{{ mediaReferenceFull }}" class="btn btn-info btn-xs x-editable-update-after-save" target="_blank" data-content-text="%s &nbsp;<i class='fa fa-external-link'></i>" {% if mediaReferenceFull is empty %}style="display: none"{% endif %}>
    {% if mediaReferenceFull is not empty %}
        {% set media = media_get(mediaReferenceFull) %}
        {% if media is proxyMedia %}
            {{ media }}
        {% else %}
            ERROR: not found
        {% endif %}
    {% endif %}
    &nbsp;<i class="fa fa-external-link"></i>
</a>

```

Use the value of the parameters.yaml for the listener:

``` yaml

services:
    avtonom.media_storage_client.listener:
        class: Avtonom\MediaStorageClientBundle\EventListener\ObjectAddFileListener
        ...
        tags:
            - { name: doctrine.event_listener, event: prePersist, method: run }
            - { name: doctrine.event_listener, event: preUpdate, method: run }
```

### Use alternative number 1: button to upload the file

``` twig

<div class="btn-group fileupload-buttonbar" role="group" aria-label="" style="display: inline-flex;">
    <span class="btn btn-primary btn-xs fileinput-button">
        {{ mediaReferenceFull is empty ? 'Add' : 'Update' }}
        &nbsp;<i class="glyphicon glyphicon-pencil"></i>
        <input type="file" name="file"
               class="file-upload fileinput-button"
               data-url="{{ url }}"
        >
    </span>
    <button type="button" class="btn btn-danger btn-xs update-button-clear delete" role="button" title="Clear" data-url="{{ url }}"><i class="fa fa-trash-o"></i></button>
</div>

```

Processing in the controller:

``` php

public function updateAction(Request $request)
{
    /** @var UploadedFile $file */
    $file = $request->files->get('file');
    if($file instanceof UploadedFile){
    
        $proxyMedia = $this->get('avtonom.media_storage_client.manager')->sendFile($file, $clientName, $context);
    
        return new JsonResponse([
            'media' => $proxyMedia->toArray(),
        ]);
    }
}
    
```
