@verbatim
    <template id="tmpl-rows">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">{{ item.canatsh }}</td>
                <td class="text-center">{{ item.presunish }}</td>
                <td class="text-center">{{ item.inco }}</td>
                <td class="text-center">{{ item.cue }}</td>
                <td class="text-center">{{ item.cte }}</td>
                <td class="text-center">{{ item.fim }}</td>
                <td class="text-center">{{ item.comp }} %</td>
            </template>

            <template v-else>
                <td class="text-center">{{ draft.namepsh }}</td>
                <td class="text-center">{{ draft.detpsh }}</td>
                <td class="text-center">
                    <input v-model="draft.canatsh"
                           type="text"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">
                    <input v-model="draft.presunish"
                           type="text"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">{{ draft.fenvp }}</td>
                <td class="text-center">
                    <input v-model="draft.fresp"
                           type="date"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">{{ draft.docs }}</td>
                <td class="text-center">
                    <a href="#" @click="update()">
                        <i class="fa fa-check"></i>
                    </a>
                    <a href="#" @click="cancel()">
                        <i class="fa fa-remove"></i>
                    </a>
                </td>
            </template>
        </tr>
    </template>
@endverbatim
