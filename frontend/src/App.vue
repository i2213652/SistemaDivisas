<template>
	<div style="background: rgb(196, 195, 195)">
		<header>
			<h1>El cambista al paso S.A.</h1>
		</header>

		<fieldset class="form-group border p-3 col-md-6 offset-md-3">
			<legend class="w-auto px-2">Datos del personal</legend>
			<div class="text-end">
				<button type="button" class="btn btn-danger" @click="Limpiar">
					<i class="bi bi-eraser-fill"></i> LIMPIAR
				</button>
			</div>
			<br />
			<div class="row">
				<div class="form-group col-md-3">
					<label for="">Código</label>
					<input
						type="text"
						class="form-control mayus text-center"
						:class="[
							submited
								? $v.frmPersona.codigo.$invalid
									? 'is-invalid'
									: 'is-valid'
								: '',
						]"
						v-model="frmPersona.codigo"
						maxlength="8"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
					/>
				</div>
				<div class="form-group col-md-3">
					<label for="">DNI/Pasaporte</label>
					<input
						type="number"
						class="form-control text-center"
						:class="[
							submited
								? $v.frmPersona.dni.$invalid
									? 'is-invalid'
									: 'is-valid'
								: '',
						]"
						v-model="frmPersona.dni"
						min="0"
						maxlength="8"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
					/>
				</div>
				<div class="row col-md-12">
					<div class="form-group col-md-6">
						<label for="">Nombres</label>
						<input
							type="text"
							class="form-control mayus"
							:class="[
								submited
									? $v.frmPersona.nombres.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
							v-model="frmPersona.nombres"
						/>
					</div>
					<div class="form-group col-md-6">
						<label for="">Apellidos</label>
						<input
							type="text"
							class="form-control mayus"
							:class="[
								submited
									? $v.frmPersona.apellidos.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
							v-model="frmPersona.apellidos"
						/>
					</div>
				</div>
				<div class="form-group col-md-3">
					<label for="">Fecha de nacimiento</label>
					<input
						type="date"
						class="form-control"
						v-model="frmPersona.fecha_nacimiento"
					/>
				</div>
				<div class="form-group col-md-9">
					<label for="">Lugar de vivienda</label>
					<textarea
						class="form-control mayus"
						rows="2"
						v-model="frmPersona.lugar_vivienda"
					/>
				</div>
				<div class="form-group col-md-3">
					<label>País</label>
					<select
						class="form-select"
						v-model="frmPersona.pais"
						:class="[
							submited
								? $v.frmPersona.pais.$invalid
									? 'is-invalid'
									: 'is-valid'
								: '',
						]"
					>
						<option :value="0" disabled>Seleccione...</option>
						<option value="PERU">Perú</option>
						<option value="CHILE">Chile</option>
						<option value="VENEZUELA">Venezuela</option>
					</select>
				</div>
			</div>
			<br />
			<div class="text-end">
				<button type="button" class="btn btn-primary" @click="Registrar">
					<i class="bi bi-check"></i> REGISTRAR
				</button>
			</div>
		</fieldset>
		<br />
		<h2 class="text-center">Lista de personas</h2>
		<div class="col-md-8 offset-md-2">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Editar</th>
						<th>Código</th>
						<th>DNI</th>
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>Fecha Nacimiento</th>
						<th>Lugar vivienda</th>
						<th>País</th>
						<th>Creado</th>
						<th>Actualizado</th>
					</tr>
				</thead>
				<tbody>
					<tr
						v-for="(item, index) in personas"
						:key="index"
						style="background: #ffffff"
					>
						<td>
							<button
								type="button"
								class="btn btn-warning"
								@click="Editar(item)"
							>
								<i class="bi bi-pencil"></i>
							</button>
						</td>
						<td>{{ item.codigo }}</td>
						<td>{{ item.dni }}</td>
						<td>{{ item.nombres }}</td>
						<td>{{ item.apellidos }}</td>
						<td>{{ item.fecha_nacimiento }}</td>
						<td>{{ item.lugar_vivienda }}</td>
						<td>{{ item.pais }}</td>
						<td>{{ item.created_at }}</td>
						<td>{{ item.updated_at }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import { required } from "vuelidate/lib/validators";
const noZero = (value) => value != 0;
export default {
	data() {
		return {
			submited: false,
			personas: [],
			frmPersona: {
				id: null,
				codigo: null,
				dni: null,
				nombres: null,
				apellidos: null,
				fecha_nacimiento: null,
				lugar_vivienda: null,
				pais: 0,
			},
		};
	},

	validations: {
		frmPersona: {
			codigo: { required },
			dni: { required },
			nombres: { required },
			apellidos: { required },
			pais: { noZero },
		},
	},
	mounted() {
		this.Listar();
	},
	methods: {
		async Listar() {
			let self = this;
			await axios
				.get("https://divisas-backend.codertec.net/api/personas")
				.then(function (response) {
					let status = response.status;
					if (status == 200) {
						return (self.personas = response.data.data);
					}
				});
		},

		Editar(item) {
			this.frmPersona.id = item.id;
			this.frmPersona.codigo = item.codigo;
			this.frmPersona.dni = item.dni;
			this.frmPersona.nombres = item.nombres;
			this.frmPersona.apellidos = item.apellidos;
			this.frmPersona.fecha_nacimiento = item.fecha_nacimiento;
			this.frmPersona.lugar_vivienda = item.lugar_vivienda;
			this.frmPersona.pais = item.pais;
		},
		async Registrar() {
			let self = this;
			this.submited = true;

			if (this.$v.frmPersona.$invalid) {
				return alert("Debe rellenar todos los datos");
			}

			if (this.frmPersona.codigo.length < 8) {
				return alert("El código debe tener 8 dígitos");
			}

			if (this.frmPersona.dni.length < 8) {
				return alert("El DNI debe tener 8 dígitos");
			}

			if (this.frmPersona.id == null) {
				await axios
					.post(
						"https://divisas-backend.codertec.net/api/personas",
						self.frmPersona
					)
					.then(function (response) {
						let status = response.status;
						if (status == 200) {
							self.Listar();
							self.Limpiar();
							self.submited = false;
							return alert("Datos guardados");
						}
					});
			} else {
				await axios
					.put(
						"https://divisas-backend.codertec.net/api/personas/" +
							self.frmPersona.id,
						self.frmPersona
					)
					.then(function (response) {
						let status = response.status;
						if (status == 200) {
							self.Listar();
							self.Limpiar();
							self.submited = false;
							return alert("Datos guardados");
						}
					});
			}
		},

		Limpiar() {
			this.frmPersona.id = null;
			this.frmPersona.codigo = null;
			this.frmPersona.dni = null;
			this.frmPersona.nombres = null;
			this.frmPersona.apellidos = null;
			this.frmPersona.fecha_nacimiento = null;
			this.frmPersona.lugar_vivienda = null;
			this.frmPersona.pais = 0;
		},
	},
};
</script>

<style>
html {
	background: rgb(196, 195, 195);
}
.mayus {
	text-transform: uppercase;
}
</style>