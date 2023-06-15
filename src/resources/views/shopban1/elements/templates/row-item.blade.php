@verbatim
    <template id="tmpl-rows">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">
                    <a href="#" v-if="item.docprov ==0" @click="update(item.iddetsh)">
                        <i class="fa fa-envelope-o" style="color: orange" title="pendiente"></i>
                    </a>
                    <a href="#"  v-if="item.docprov ==1" @click="update(item.iddetsh)">
                        <i class="fa fa-envelope" style="color: orange" title="enviado"></i>
                    </a>
                </td>
            </template>

            <template v-else>
                <td>{{ draft.cart }}</td>
                <td>{{ draft.nart }}</td>
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
