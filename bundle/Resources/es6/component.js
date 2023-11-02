const handlePostRequest = async (componentIdentifier, componentId) => {
    const data = localStorage.getItem(`nglayouts-bitbag-component-draft-${componentIdentifier}`);
    if (!data) return;

    const { blockId, locale } = JSON.parse(data);

    const nglayoutsBasePathElement = document.querySelector('[name="nglayouts-base-path"]');
    const nglayoutsBasePath = nglayoutsBasePathElement && nglayoutsBasePathElement.getAttribute('content');

    const url = `${nglayoutsBasePath}bitbag/admin/blocks/${blockId}/${locale}/connect-component-content/${componentIdentifier}/${componentId}`;

    console.log(url);

    const bc = new BroadcastChannel('publish_content');

    await fetch(url, { method: 'post' })
        .then(() => {
            bc.postMessage(JSON.parse(data));
        })
        .then(() => {
            bc.close();
            localStorage.removeItem(`nglayouts-bitbag-component-draft-${componentIdentifier}`);
        });
};

const saveDataToLocalStorage = (hash, componentIdentifier) => {
    if (!hash.includes('#ngl-bitbag-component/')) return;

    const params = hash.replace('#ngl-bitbag-component/', '').split('/');
    const blockId = params[0];
    const locale = params[1];
    const componentIdentifierFromHash = params[2];

    if (componentIdentifier !== componentIdentifierFromHash) return;

    const data = { blockId, locale, componentIdentifier };
    localStorage.setItem(`nglayouts-bitbag-component-draft-${componentIdentifier}`, JSON.stringify(data));
};

const connectBlockAndContent = async () => {
    const urlHash = window.location.hash;

    const bitbagComponentDraftIdentifierElement = document.querySelector('[name="nglayouts-sylius-bitbag-component-initialize-create-identifier"]');
    const bitbagComponentDraftIdentifier = bitbagComponentDraftIdentifierElement && bitbagComponentDraftIdentifierElement.getAttribute('content');

    if (bitbagComponentDraftIdentifier) {
        saveDataToLocalStorage(urlHash, bitbagComponentDraftIdentifier);

        return;
    }

    const indexComponentIdentifierElement = document.querySelector('[name="nglayouts-sylius-bitbag-component-index-identifier"]');
    const indexComponentIdentifier = indexComponentIdentifierElement && indexComponentIdentifierElement.getAttribute('content');

    const showComponentIdentifierElement = document.querySelector('[name="nglayouts-sylius-bitbag-component-show-identifier"]');
    const showComponentIdentifier = showComponentIdentifierElement && showComponentIdentifierElement.getAttribute('content');

    const createdComponentIdentifier = indexComponentIdentifier || showComponentIdentifier;

    const indexComponentIdElement = document.querySelector('[name="nglayouts-sylius-bitbag-component-index-selected-id"]');
    const indexComponentId = indexComponentIdElement && indexComponentIdElement.getAttribute('content');

    const showComponentIdElement = document.querySelector('[name="nglayouts-sylius-bitbag-component-show-id"]');
    const showComponentId = showComponentIdElement && showComponentIdElement.getAttribute('content');

    const createdComponentId = indexComponentId || showComponentId;

    if (createdComponentIdentifier && createdComponentId) {
        handlePostRequest(createdComponentIdentifier, createdComponentId);
    }
};

window.addEventListener('DOMContentLoaded', () => {
    connectBlockAndContent();
});
