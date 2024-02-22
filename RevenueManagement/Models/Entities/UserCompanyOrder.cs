using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RevenueManagement.Models.Entities
{
    [Table("user_company_orders")]
    public class UserCompanyOrder
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "bigint")]
        public long Id { get; set; }

        [Column("user_id")]
        public long? UserId { get; set; }

        [Column("company_id")]
        public long? CompanyId { get; set; }

        [Column("order_id")]
        public long? OrderId { get; set; }

        [Column("created_at")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        public User? User { get; set; }

        public Company? Company { get; set; }

        public Order? Order { get; set; }
    }
}
