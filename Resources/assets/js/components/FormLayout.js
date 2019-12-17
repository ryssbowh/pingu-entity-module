import * as h from 'PinguHelpers';

const FormLayout = (() => {

    function viewOptionsUri(field)
    {
        let uri = '/'+h.config('entity.uris.viewFormLayoutOptions');
        return h.replaceUriSlugs(uri, [field]);
    }

    function editOptionsUri(field)
    {
        let uri = '/'+h.config('entity.uris.editFormLayoutOptions');
        return h.replaceUriSlugs(uri, [field]);
    }

    return {
        viewOptionsUri: viewOptionsUri,
        editOptionsUri: editOptionsUri
    };

})();

export default FormLayout;