using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;

namespace RevenueManagement.Models.Entities
{
    [Table("user_companies")]
    public class UserCompany
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "bigint")]
        public long Id { get; set; }

        [Column("user_id")]
        public long UserId { get; set; }

        [Column("company_id")]
        public long CompanyId { get; set; }

        [Column("created_at")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        public User? User { get; set; }

        public Company? Company { get; set; }
    }
}
