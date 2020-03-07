const FormLayout = (() => {

    function viewOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.viewFormLayoutOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    function editOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.editFormLayoutOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    return {
        viewOptionsUri: viewOptionsUri,
        editOptionsUri: editOptionsUri
    };

})();

export default FormLayout;