
<template>
	<div>
		<header class="bg-white">
			<h1 class="text-center">El cambista al paso S.A.</h1>
		</header>

		<fieldset class="form-group border p-3 col-md-6 offset-md-3 bg-white">
			<legend class="w-auto px-2">Datos del personal</legend>

			<br />
			<div class="row">
				<div class="form-group col-md-3">
					<label for="">Código</label>
					<input
						type="text"
						class="form-control mayus text-center"
						:value="frmPersona.codigo"
						disabled
					/>
				</div>
				<div class="form-group col-md-3">
					<div class="form-check">
						<input
							class="form-check-input"
							type="radio"
							v-model="frmPersona.tipo_documento"
							value="DNI"
							id="rdbDni"
							:disabled="deshabilitado"
						/>
						<label class="form-check-label" for="rdbDni"> DNI </label>
					</div>
					<div class="form-check">
						<input
							class="form-check-input"
							type="radio"
							v-model="frmPersona.tipo_documento"
							value="PASAPORTE"
							id="rdbPasaporte"
							:disabled="deshabilitado"
						/>
						<label class="form-check-label" for="rdbPasaporte">
							PASAPORTE
						</label>
					</div>
				</div>

				<div class="form-group col-md-3">
					<label for="">{{ frmPersona.tipo_documento }}</label>
					<input
						type="number"
						class="form-control text-center"
						:class="[
							submited
								? $v.frmPersona.documento.$invalid ||
								  frmPersona.documento.length != limite_documento // eslint-disable-line no-mixed-spaces-and-tabs
									? 'is-invalid'
									: 'is-valid'
								: '',
						]"
						v-model="frmPersona.documento"
						min="0"
						:maxlength="limite_documento"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
						:disabled="deshabilitado"
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
							:disabled="deshabilitado"
							onkeydown="return /[a-z, ]/i.test(event.key)"
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
							:disabled="deshabilitado"
							onkeydown="return /[a-z, ]/i.test(event.key)"
						/>
					</div>
				</div>
				<div class="form-group col-md-4">
					<label for="">Fecha de nacimiento</label>
					<input
						type="date"
						class="form-control"
						:class="[
							submited
								? $v.frmPersona.fecha_nacimiento.$invalid
									? 'is-invalid'
									: 'is-valid'
								: '',
						]"
						v-model="frmPersona.fecha_nacimiento"
						:disabled="deshabilitado"
					/>
				</div>
				<div class="form-group col-md-8">
					<label for="">Lugar de vivienda</label>
					<textarea
						class="form-control mayus"
						rows="2"
						v-model="frmPersona.lugar_vivienda"
						:disabled="deshabilitado"
					/>
				</div>
				<div class="form-group col-md-3">
					<label>País</label>
					<select
						class="form-select"
						v-model="frmPersona.pais"
						:disabled="deshabilitado"
					>
						<option :value="0" disabled>Seleccione...</option>
						<option value="PERU">Perú</option>
						<option value="COLOMBIA">Colombia</option>
						<option value="BRASIL">Brasil</option>
						<option value="CHILE">Chile</option>
						<option value="ARGENTINA">Argentina</option>
						<option value="OTROS">Otros</option>
					</select>
				</div>
			</div>
			<br />
			<div class="text-center">
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
					<button
						type="button"
						class="btn btn-primary"
						@click="Agregar"
						v-if="modo != 'EDICION'"
					>
						<i class="bi bi-plus-circle"></i> AGREGAR
					</button>
					<button
						type="button"
						class="btn btn-warning"
						v-if="modo != 'EDICION'"
						@click="Actualizar"
					>
						<i class="bi bi-arrow-clockwise"></i> ACTUALIZAR
					</button>
					<button
						type="button"
						class="btn btn-success"
						v-if="modo == 'EDICION'"
						@click="Grabar"
					>
						<i class="bi bi-save-fill"></i> GRABAR
					</button>
					<button
						type="button"
						class="btn btn-danger"
						v-if="modo == 'EDICION'"
						@click="Cancelar"
					>
						<i class="bi bi-x-circle"></i>
						CANCELAR
					</button>
				</div>
			</div>
		</fieldset>
		<br />
		<div class="col-md-10 offset-md-1 bg-white">
			<h2 class="text-center">Lista de personas</h2>
			<table class="table table-hover table-responsive">
				<thead>
					<tr>
						<th>N°</th>
						<th>CÓDIGO</th>
						<th>NOMBRES</th>
						<th>APELLIDOS</th>
						<th>TIPO DOCUMENTO</th>
						<th>DOCUMENTO</th>
						<th>FECHA NACIMIENTO</th>
						<th>LUGAR VIVIENDA</th>
						<th>PAÍS</th>
						<th>CREADO</th>
						<th>ACTUALIZADO</th>
					</tr>
				</thead>
				<tbody>
					<tr
						v-for="(item, index) in personas"
						:key="index"
						style="background: #ffffff"
					>
						<td>
							{{ index + 1 }}
						</td>
						<td align="center">{{ item.codigo }}</td>
						<td>{{ item.nombres }}</td>
						<td>{{ item.apellidos }}</td>
						<td align="center">{{ item.tipo_documento }}</td>
						<td align="center">{{ item.documento }}</td>
						<td align="center">{{ item.fecha_nacimiento }}</td>
						<td>{{ item.lugar_vivienda }}</td>
						<td align="center">{{ item.pais }}</td>
						<td align="center">{{ item.created_at }}</td>
						<td align="center">{{ item.updated_at }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import { required } from "vuelidate/lib/validators";

export default {
	data() {
		return {
			submited: false,
			personas: [],
			frmPersona: {
				id: null,
				codigo: null,
				tipo_documento: "DNI",
				documento: null,
				nombres: null,
				apellidos: null,
				fecha_nacimiento: null,
				lugar_vivienda: null,
				pais: 0,
			},
			modo: "VISTA",
			deshabilitado: true,
		};
	},

	validations() {
		return {
			frmPersona: {
				documento: { required },
				nombres: { required },
				apellidos: { required },
				fecha_nacimiento: { required },
			},
		};
	},
	computed: {
		limite_documento() {
			let cantidad_digitos = 0;
			if (this.frmPersona.tipo_documento == "DNI") {
				cantidad_digitos = 8;
			} else if (this.frmPersona.tipo_documento == "PASAPORTE") {
				cantidad_digitos = 10;
			}
			return cantidad_digitos;
		},
	},
	mounted() {
		document.title = "Sistema divisas";
		this.Listar();
	},
	methods: {
		async Listar() {
			let self = this;
			await this.$axios.get("/api/personas").then(function (response) {
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

		Agregar() {
			this.deshabilitado = false;
			this.modo = "EDICION";
		},
		async Actualizar() {
			let self = this;
			const inputOptions = { 0: "DNI", 1: "PASAPORTE" };

			const { value: tipo_documento } = await this.$swal.fire({
				title: "TIPO DE DOCUMENTO",
				input: "radio",
				inputOptions: inputOptions,
				confirmButtonText: "Siguiente",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				inputValidator: (value) => {
					if (!value) {
						return "Por favor escoja una opción";
					}
				},
			});

			if (tipo_documento) {
				let tipo = inputOptions[tipo_documento];
				this.$swal.fire({
					title: "INGRESE EL " + tipo,
					input: "number",
					showCancelButton: true,
					confirmButtonText: "OK",
					showLoaderOnConfirm: true,
					inputValidator: (value) => {
						if (tipo == "DNI" && value.length != 8) {
							return "El DNI debe tener 8 dígitos";
						} else if (tipo == "PASAPORTE" && value.length != 10) {
							return "El PASAPORTE debe tener 10 dígitos";
						}
					},
					preConfirm: (documento) => {
						self.$axios
							.get("/api/personas/" + tipo + "/" + documento)
							.then(function (response) {
								let status = response.status;

								if (status == 200) {
									let data = response.data.data;

									if (data != null) {
										self.submited = false;
										self.deshabilitado = false;
										self.modo = "EDICION";
										self.frmPersona = data;
										return self.$swal.fire({
											icon: "success",
											title: "¡PERSONA ENCONTRADA!",
											timer: 1200,
											showConfirmButton: false,
										});
									} else {
										return self.$swal.fire({
											icon: "error",
											title: "¡Ups!",
											text: "No se encontró ningún resultado",
											allowOutsideClick: false,
										});
									}
								}
							});
					},
					allowOutsideClick: () => !this.$swal.isLoading(),
				});
			}
		},
		Cancelar() {
			this.submited = false;
			this.deshabilitado = true;
			this.modo = "VISTA";
			this.Limpiar();
		},
		async Grabar() {
			let self = this;
			this.submited = true;

			if (this.$v.frmPersona.$invalid) {
				this.$swal.fire({
					icon: "warning",
					title: "¡Ups!",
					text: "Faltan registrar algunos campos",
					allowOutsideClick: false,
				});
				return false;
			}

			if (this.frmPersona.documento.length != this.limite_documento) {
				let tipo_documento = this.frmPersona.tipo_documento;

				this.$swal.fire({
					icon: "warning",
					title: "¡Ups!",
					text:
						"El " +
						tipo_documento +
						" debe contener " +
						this.limite_documento +
						" dígitos",
					allowOutsideClick: false,
				});
				return false;
			}

			let fecha_nacimiento = this.moment(this.frmPersona.fecha_nacimiento);
			let diferencia_anios = this.moment().diff(fecha_nacimiento, "years");

			if (diferencia_anios < 18) {
				this.frmPersona.fecha_nacimiento = null;
				this.$swal.fire({
					icon: "warning",
					title: "¡Ups!",
					text: "La persona no es mayor de edad",
					allowOutsideClick: false,
				});
				return false;
			}

			if (this.frmPersona.id == null) {
				await this.$axios
					.post("/api/personas", self.frmPersona)
					.then(function (response) {
						let status = response.status;
						let verificacion = response.data.verificacion;

						if (status == 200) {
							if (verificacion == "EXISTE") {
								self.frmPersona.documento = null;
								return self.$swal.fire({
									icon: "error",
									title: "¡Ups!",
									text: "El documento ingresado ya se encuentra registrado.",
									allowOutsideClick: false,
								});
							} else {
								self.Listar();
								self.Limpiar();
								self.submited = false;
								self.deshabilitado = true;
								self.modo = "VISTA";
								return self.$swal.fire({
									icon: "success",
									title: "¡ÉXITO!",
									timer: 1200,
									showConfirmButton: false,
								});
							}
						}
					});
			} else {
				await this.$axios
					.put("/api/personas/" + self.frmPersona.id, self.frmPersona)
					.then(function (response) {
						let status = response.status;
						if (status == 200) {
							self.Listar();
							self.Limpiar();
							self.submited = false;
							self.deshabilitado = true;
							self.modo = "VISTA";
							return self.$swal.fire({
								icon: "success",
								title: "¡ÉXITO!",
								timer: 1200,
								showConfirmButton: false,
							});
						}
					});
			}
		},

		Limpiar() {
			this.frmPersona.id = null;
			this.frmPersona.codigo = null;
			this.frmPersona.tipo_documento = "DNI";
			this.frmPersona.documento = null;
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
body {
	background-image: url("assets/money.jpeg");
}
.mayus {
	text-transform: uppercase;
}
</style>