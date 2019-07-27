<script>
import MultiSelect from './MultiSelect';

export default {
    extends: MultiSelect,
    props: {
        optionsApiPath: {
            type: String,
            default: '/places/search'
        },
        clearAllButton: {
            type: Boolean,
            default: true
        },
        poweredByGoogle: {
            type: Boolean,
            default: true
        },
        closeOnSelect: {
            type: Boolean,
            default: true
        },
        clearOnSelect: {
            type: Boolean,
            default: true
        },
        multiple: {
            type: Boolean,
            default: false
        },
        value: {
            type: Object,
            default: function () {
                return null;
            }
        },
        options: {
            type: Array,
            default: function () {
                return [];
            }
        },
        trackBy: {
            type: String,
            default: 'uid'
        },
        prefetchResults: {
            type: Boolean,
            default: false
        },
        afterListTemplate: {
            type: String,
            default: '<img\n' +
                ' src="/img/powered_by_google.png"\n' +
                ' class="p-2"' +
                ' alt="Powered by Google">'
        },
    }

};
</script>

