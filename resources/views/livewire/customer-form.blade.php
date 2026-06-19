<div>

    <div style="
        background: #f3f3f3;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    ">

        <h2 style="margin-bottom: 20px;">Registro de Usuario</h2>

        <form wire:submit.prevent="save">

            {{-- Nombre --}}
            <div style="margin-bottom: 15px; text-align:left;">
                <label>Nombre completo</label>
                <input type="text" wire:model="Nombre"
                    placeholder="Ej: Juan Pérez"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                @error('Nombre') <span style="color:red;">{{ $message }}</span> @enderror
            </div>

            {{-- Teléfono --}}
            <div style="margin-bottom: 15px; text-align:left;">
                <label>Teléfono</label>
                <input type="text" wire:model="Telefono"
                    placeholder="Ej: +57 300 123 4567"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            {{-- Sexo --}}
            <div style="margin-bottom: 15px; text-align:left;">
                <label>Sexo</label>
                <select wire:model="Sexo"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    <option value="">Seleccione una opción</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            {{-- Tipo --}}
            <div style="margin-bottom: 15px; text-align:left;">
                <label>Tipo de usuario</label>
                <select wire:model="Tipo"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    <option value="">Seleccione una opción</option>
                    <option value="Adulto">Adulto</option>
                    <option value="Niño">Niño</option>
                </select>
            </div>

            {{-- Estado --}}
            <div style="margin-bottom: 20px; text-align:left;">
                <label>Estado</label>
                <select wire:model="EstadoCustomer"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    <option value="">Seleccione una opción</option>
                    <option value="Pago">Pago</option>
                    <option value="Debe">Debe</option>
                </select>
            </div>

            {{-- Botón --}}
            <button type="submit" style="
                width:100%;
                padding:12px;
                background:#2d2a26;
                color:white;
                border:none;
                border-radius:10px;
                font-weight:bold;
                cursor:pointer;
            ">
                Registrar
            </button>

        </form>
    </div>

    {{-- 🔥 MODAL --}}
    @if($showModal)
        <div style="
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.6);
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:9999;
        ">
            <div style="
                background:white;
                padding:30px;
                border-radius:15px;
                text-align:center;
                max-width:300px;
            ">
                <h3>✅ Registro exitoso</h3>
                <p>Tu código es:</p>

                <h2 style="color:#007bff; margin:15px 0;">
                    {{ $codigoGenerado }}
                </h2>

                <a
                    href="{{ route('customer.pdf', $customerRegistrado->IdCustomer) }}"
                    target="_blank"
                    style="
                        display:inline-block;
                        padding:10px 20px;
                        background:#007bff;
                        color:white;
                        text-decoration:none;
                        border-radius:8px;
                        margin-right:10px;
                    "
                >
                    📄 Descargar PDF
                </a>

                <button wire:click="$set('showModal', false)"
                    style="
                        padding:10px 20px;
                        background:#28a745;
                        color:white;
                        border:none;
                        border-radius:8px;
                        cursor:pointer;
                    ">
                    Cerrar
                </button>
            </div>
        </div>
    @endif

</div>