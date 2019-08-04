<script>
import MultiSelect from './MultiSelect';

export default {
    extends: MultiSelect,
    props: {
        optionsApiPath: {
            type: String,
            default: '/user/search'
        },
        clearAllButton: {
            type: Boolean,
            default: false
        },
        poweredByGoogle: {
            type: Boolean,
            default: false
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
            default: 'username'
        },
        prefetchResults: {
            type: Boolean,
            default: true
        },
        afterListTemplate: {
            type: String,
            default: null
        },
    }

};
</script>

