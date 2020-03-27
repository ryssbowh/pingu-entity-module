const FieldDisplay = (() => {

    function viewOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.viewFieldDisplayOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    function editOptionsUri(field)
    {
        let uri = '/'+Config.get('entity.uris.editFieldDisplayOptions');
        return Helpers.replaceUriSlugs(uri, [field]);
    }

    return {
        viewOptionsUri: viewOptionsUri,
        editOptionsUri: editOptionsUri
    };

})();

export default FieldDisplay;