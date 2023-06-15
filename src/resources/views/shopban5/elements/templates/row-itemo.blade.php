@verbatim
    <template id="tmpl-rows">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">{{ item.oca }}</td>
                <td class="text-center">{{ item.osa }}</td>
                <td class="text-center">{{ item.olo }}</td>
                <td class="text-center">{{ item.oin }}</td>
                <td class="text-center">{{ item.docs }}</td>
                <td class="text-center">
                    <a href="#" class="updateinfo" onclick="showModalList(1)" :data-nom="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-file-o" title="Carga Documento"></i>
                    </a>&nbsp;
                    <a href="#" class="obsrev" :data-ida="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-check-square" style="color: blue"></i>
                    </a>
                </td>
            </template>

            <template v-else>
                <td class="text-center">{{ draft.namepsh }}</td>
                <td class="text-center">{{ draft.detpsh }}</td>
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
