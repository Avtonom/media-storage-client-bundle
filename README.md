# Сlient for SonataMediaBundle
Symfony media client bundle for uploading (sending) files and images to a remote server deployed on SonataMediaBundle

"avtonom/media-storage-client-bundle": "~1.1",

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),
            new Avtonom\MediaStorageClientBundle\AvtonomMediaStorageClientBundle(),
        ];
    }


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
        change_field: value
        ignored_domains: ['s.dev.demo.com', 's.prod.demo.com']
        client: client_name_url
        context: context
    logging_level: 100


\web\bower.json
    "blueimp-file-upload-node": "*"

\src\Bundle\Resources\views\standard_layout.html.twig

{% block javascripts %}
    {{ parent() }}
    {% javascripts
        '@AvtonomMediaStorageClientBundle/Resources/public/js/actions.js'
    %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}


controller:
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        if($file instanceof UploadedFile){

        $proxyMedia = $this->get('avtonom.media_storage_client.manager')->sendFile($file, $clientName, $context);

        return new JsonResponse([
            'status' => 'OK',
            'value' => $proxyMedia->toArray(),
        ]);