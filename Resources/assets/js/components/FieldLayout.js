const FieldLayout = (() => {

    function viewOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.viewFieldLayoutOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    function editOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.editFieldLayoutOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    return {
        viewOptionsUri: viewOptionsUri,
        editOptionsUri: editOptionsUri
    };

})();

export default FieldLayout;