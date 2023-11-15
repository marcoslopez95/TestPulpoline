import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

export const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    defaults: {
        VTextField: { variant: 'outlined' },
        VSelect: { variant: 'outlined' },
    },
})