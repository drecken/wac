export const usePaginationStore = defineStore('pagination', () => {

    const links = ref([] as Link[])

    function setLinks(newLinks: []) {
        links.value = []
        newLinks.forEach((link: any) => {
            links.value.push({
                ...link,
                url: link.url ? formatUrl(link.url) : link.url,
            })
        })
    }

    function formatUrl(url: string) {
        return decodeURI(url.replace(/^\/api/, ''))
    }

    return {links, setLinks}
})

interface Link {
    url: string | null,
    label: string,
    active: boolean,
}

