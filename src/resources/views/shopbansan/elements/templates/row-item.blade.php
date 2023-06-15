@verbatim
    <template id="tmpl-rows">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">{{ item.fenvp }}</td>
                <td class="text-center">
                    <a href="#" class="updateinfo" v-if="item.stinv == 1">
                        <i class="fa fa-circle" style="color: #079135"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">D</p></i>
                    </a>
                    <a href="#" class="updateinfo" v-if="item.stinv == 2">
                        <i class="fa fa-circle" style="color: #FD553E"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">D</p></i>
                    </a>
                    <a href="#" class="updateinfo" v-if="item.stlog == 1">
                        <i class="fa fa-circle" style="color: #079135"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">L</p></i>
                    </a>
                    <a href="#" class="updateinfo" v-if="item.stlog == 2">
                        <i class="fa fa-circle" style="color: #FD553E"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">L</p></i>
                    </a>
                    <a href="#" class="updateinfo" v-if="item.stsan == 1">
                        <i class="fa fa-circle" style="color: #079135"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">S</p></i>
                    </a>
                    <a href="#" class="updateinfo" v-if="item.stsan == 2">
                        <i class="fa fa-circle" style="color: #FD553E"><p style="font-family: Arial;font-size: 9px; font-weight: bold;color: black">S</p></i>
                    </a>
                </td>
                <td class="text-center">{{ item.osa }}</td>
                <td class="text-center">
                    <a href="#" @click="edit()">
                        <i class="fa fa-edit" title="registrar obs"></i>
                    </a>&nbsp;
                    <a href="#" class="updateinfo" onclick="showModalList(1)" :data-nom="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-folder"></i>
                    </a>&nbsp;
                    <a href="#" v-if="item.stsan == 1" class="addocwin" onclick="showModaladd(1)" :data-now="item.iddetsh" :data-dew="item.detpsh">
                        <i class="fa fa-list"></i>
                    </a>&nbsp;
                    <a href="#" v-if="item.stsan == 0" class="aprov" :data-ida="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-check-square" style="color: green"></i>
                    </a>&nbsp;
                    <a href="#" v-if="item.stsan == 0" class="reprov"  :data-idr="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-times-rectangle" style="color: red"></i>
                    </a>
                </td>
            </template>

            <template v-else>
                <td class="text-center">{{ draft.namepsh }}</td>
                <td class="text-center">{{ draft.detpsh }}</td>
                <td class="text-center">{{ draft.fenvp }}</td>
                <td class="text-center"></td>
                <td class="text-center">
                    <input v-model="draft.osa"
                           type="text"
                           class="form-control input-sm-table text-right">
                </td>
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
