export const usePaginationStore = defineStore('pagination', () => {

    const links = ref([] as Link[])

    const meta = ref({
        from: null,
        to: null,
        total: 0,
    } as Meta)

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

    return {links, meta, setLinks}
})

interface Link {
    url: string | null,
    label: string,
    active: boolean,
}

interface Meta {
    from: number | null,
    to: number | null,
    total: number,
}

