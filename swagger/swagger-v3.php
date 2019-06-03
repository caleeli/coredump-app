<?php
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Coredump API",
 *         description="",
 *         @OA\Contact(
 *             email="info@coredump.com"
 *         ),
 *         @OA\License(
 *             name="Apache 2.0",
 *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     ),
 * )
 * @OA\Get(
 *     path="/api/data/users",
 *     summary="Mostrar usuarios",
 *     @OA\Response(
 *         response=200,
 *         description="Mostrar todos los usuarios."
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Lista de usuarios."
 *     )
 * )
 *
 */
