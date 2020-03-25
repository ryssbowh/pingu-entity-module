const FieldDisplay = (() => {

    function viewOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.viewDisplayOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    function editOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.editDisplayOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    return {
        viewOptionsUri: viewOptionsUri,
        editOptionsUri: editOptionsUri
    };

})();

export default FieldDisplay;