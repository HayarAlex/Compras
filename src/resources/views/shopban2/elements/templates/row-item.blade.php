@verbatim
    <template id="tmpl-rows">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">{{ item.canatsh }}</td>
                <td class="text-center">{{ item.presunish }}</td>
                <td class="text-center">
                    <a href="#" v-if="item.tipop ==1" style="color: black;margin-top: 1px">
                        <p>Bs</p>
                    </a>
                    <a href="#" v-if="item.tipop ==2" style="color: black;margin-top: 1px">
                        <p>USD</p>
                    </a>
                </td>
                <td class="text-center">{{ item.inco }}</td>
                <td class="text-center">{{ item.fim }}</td>
                <td class="text-center">{{ item.fresp }}</td>
                <td class="text-center">{{ item.docs }}</td>
                <td class="text-center">
                    <a href="#" @click="edit()">
                        <i class="fa fa-edit" title="Adición infomación"></i>
                    </a>&nbsp;&nbsp;
                    <a href="#" class="updateinfo" onclick="showModalList(1)" :data-nom="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-file-o" title="Carga Documento"></i>
                    </a>
                </td>
            </template>

            <template v-else>
                <td class="text-center">{{ draft.namepsh }}</td>
                <td class="text-center">{{ draft.detpsh }}</td>
                <td class="text-center">
                    <input v-model="draft.canatsh"
                           type="number"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">
                    <input v-model="draft.presunish"
                           type="number"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">
                    <select v-model="draft.tipop" class="form-control input-sm-table text-right">
                        <option disabled value="">Seleccione un elemento</option>
                        <option value="1">Bs</option>
                        <option value="2">USD</option>
                    </select>
                </td>
                <td class="text-center">
                    <input v-model="draft.inco"
                           type="text"
                           class="form-control input-sm-table text-right">
                </td>
                <td class="text-center">
                    <input v-model="draft.fim"
                           type="number"
                           class="form-control input-sm-table text-right">
                </td>
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
