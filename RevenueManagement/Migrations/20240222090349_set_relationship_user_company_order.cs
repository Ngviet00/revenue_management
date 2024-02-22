using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace RevenueManagement.Migrations
{
    /// <inheritdoc />
    public partial class set_relationship_user_company_order : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateIndex(
                name: "IX_user_company_orders_company_id",
                table: "user_company_orders",
                column: "company_id");

            migrationBuilder.CreateIndex(
                name: "IX_user_company_orders_order_id",
                table: "user_company_orders",
                column: "order_id");

            migrationBuilder.CreateIndex(
                name: "IX_user_company_orders_user_id",
                table: "user_company_orders",
                column: "user_id");

            migrationBuilder.AddForeignKey(
                name: "FK_user_company_orders_companies_company_id",
                table: "user_company_orders",
                column: "company_id",
                principalTable: "companies",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);

            migrationBuilder.AddForeignKey(
                name: "FK_user_company_orders_orders_order_id",
                table: "user_company_orders",
                column: "order_id",
                principalTable: "orders",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);

            migrationBuilder.AddForeignKey(
                name: "FK_user_company_orders_users_user_id",
                table: "user_company_orders",
                column: "user_id",
                principalTable: "users",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_user_company_orders_companies_company_id",
                table: "user_company_orders");

            migrationBuilder.DropForeignKey(
                name: "FK_user_company_orders_orders_order_id",
                table: "user_company_orders");

            migrationBuilder.DropForeignKey(
                name: "FK_user_company_orders_users_user_id",
                table: "user_company_orders");

            migrationBuilder.DropIndex(
                name: "IX_user_company_orders_company_id",
                table: "user_company_orders");

            migrationBuilder.DropIndex(
                name: "IX_user_company_orders_order_id",
                table: "user_company_orders");

            migrationBuilder.DropIndex(
                name: "IX_user_company_orders_user_id",
                table: "user_company_orders");
        }
    }
}
